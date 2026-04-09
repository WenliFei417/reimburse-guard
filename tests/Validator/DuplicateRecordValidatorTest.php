<?php

namespace App\Tests\Validator;

use App\Validator\DuplicateRecordValidator;
use PHPUnit\Framework\TestCase;

class DuplicateRecordValidatorTest extends TestCase
{
    private DuplicateRecordValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new DuplicateRecordValidator();
    }

    public function testFirstRecordPasses(): void
    {
        $record = ['patient_id' => 'P001', 'service_date' => '2024-03-01', 'claim_type' => 'inpatient'];
        $this->assertNull($this->validator->validate($record));
    }

    public function testDuplicateRecordFails(): void
    {
        $record = ['patient_id' => 'P001', 'service_date' => '2024-03-01', 'claim_type' => 'inpatient'];
        $this->validator->validate($record);
        $this->assertNotNull($this->validator->validate($record));
    }

    public function testDifferentPatientPasses(): void
    {
        $record1 = ['patient_id' => 'P001', 'service_date' => '2024-03-01', 'claim_type' => 'inpatient'];
        $record2 = ['patient_id' => 'P002', 'service_date' => '2024-03-01', 'claim_type' => 'inpatient'];
        $this->validator->validate($record1);
        $this->assertNull($this->validator->validate($record2));
    }
}