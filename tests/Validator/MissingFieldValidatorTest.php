<?php

namespace App\Tests\Validator;

use App\Validator\MissingFieldValidator;
use PHPUnit\Framework\TestCase;

class MissingFieldValidatorTest extends TestCase
{
    private MissingFieldValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new MissingFieldValidator();
    }

    public function testValidRecordPassesValidation(): void
    {
        $record = [
            'record_id'         => 'R001',
            'patient_id'        => 'P001',
            'provider_name'     => 'General Hospital',
            'service_date'      => '2024-03-01',
            'claim_type'        => 'inpatient',
            'billed_amount'     => '1000.00',
            'reimbursed_amount' => '800.00',
        ];
        $this->assertNull($this->validator->validate($record));
    }

    public function testMissingServiceDateFails(): void
    {
        $record = [
            'record_id'         => 'R001',
            'patient_id'        => 'P001',
            'provider_name'     => 'General Hospital',
            'service_date'      => '',
            'claim_type'        => 'inpatient',
            'billed_amount'     => '1000.00',
            'reimbursed_amount' => '800.00',
        ];
        $this->assertNotNull($this->validator->validate($record));
    }

    public function testMissingPatientIdFails(): void
    {
        $record = [
            'record_id'         => 'R001',
            'patient_id'        => '',
            'provider_name'     => 'General Hospital',
            'service_date'      => '2024-03-01',
            'claim_type'        => 'inpatient',
            'billed_amount'     => '1000.00',
            'reimbursed_amount' => '800.00',
        ];
        $this->assertNotNull($this->validator->validate($record));
    }
}