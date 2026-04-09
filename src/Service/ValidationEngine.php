<?php

namespace App\Service;

use App\Validator\MissingFieldValidator;
use App\Validator\InvalidDateValidator;
use App\Validator\InvalidAmountValidator;
use App\Validator\ReimbursementExceedsBilledValidator;
use App\Validator\DuplicateRecordValidator;
use Doctrine\DBAL\Connection;

class ValidationEngine
{
    private array $validators;

    public function __construct(private Connection $connection)
    {
        $this->validators = [
            'missing_field'          => new MissingFieldValidator(),
            'invalid_date'           => new InvalidDateValidator(),
            'invalid_amount'         => new InvalidAmountValidator(),
            'reimbursement_exceeds'  => new ReimbursementExceedsBilledValidator(),
            'duplicate_record'       => new DuplicateRecordValidator(),
        ];
    }

    public function runAll(): int
    {
        // 清除旧的异常
        $this->connection->executeStatement('DELETE FROM exceptions');

        $records = $this->connection->fetchAllAssociative('SELECT * FROM records');
        $count = 0;

        foreach ($records as $record) {
            foreach ($this->validators as $ruleName => $validator) {
                $error = $validator->validate($record);
                if ($error !== null) {
                    $this->connection->insert('exceptions', [
                        'record_db_id'  => $record['id'],
                        'rule_name'     => $ruleName,
                        'message'       => $error,
                        'review_status' => 'new',
                        'created_at'    => date('Y-m-d H:i:s'),
                    ]);
                    $count++;
                }
            }
        }
        return $count;
    }
}