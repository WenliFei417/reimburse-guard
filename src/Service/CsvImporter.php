<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class CsvImporter
{
    public function __construct(private Connection $connection) {}

    public function import(string $filePath): int
    {
        $count = 0;
        if (($handle = fopen($filePath, 'r')) === false) {
            return 0;
        }

        $headers = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($headers, $row);
            $this->connection->insert('records', [
                'record_id'         => $data['record_id'] ?? '',
                'patient_id'        => $data['patient_id'] ?? '',
                'provider_name'     => $data['provider_name'] ?? '',
                'service_date'      => $data['service_date'] ?? '',
                'claim_type'        => $data['claim_type'] ?? '',
                'billed_amount'     => $data['billed_amount'] ?? '',
                'reimbursed_amount' => $data['reimbursed_amount'] ?? '',
                'status'            => $data['status'] ?? '',
                'imported_at'       => date('Y-m-d H:i:s'),
            ]);
            $count++;
        }

        fclose($handle);
        return $count;
    }
}