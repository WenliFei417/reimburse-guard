<?php

namespace App\Tests\Validator;

use App\Validator\InvalidAmountValidator;
use PHPUnit\Framework\TestCase;

class InvalidAmountValidatorTest extends TestCase
{
    private InvalidAmountValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new InvalidAmountValidator();
    }

    public function testValidAmountPasses(): void
    {
        $this->assertNull($this->validator->validate([
            'billed_amount' => '1000.00',
            'reimbursed_amount' => '800.00',
        ]));
    }

    public function testZeroBilledAmountFails(): void
    {
        $this->assertNotNull($this->validator->validate([
            'billed_amount' => '0',
            'reimbursed_amount' => '0',
        ]));
    }

    public function testNegativeBilledAmountFails(): void
    {
        $this->assertNotNull($this->validator->validate([
            'billed_amount' => '-100',
            'reimbursed_amount' => '0',
        ]));
    }

    public function testNegativeReimbursedAmountFails(): void
    {
        $this->assertNotNull($this->validator->validate([
            'billed_amount' => '1000',
            'reimbursed_amount' => '-50',
        ]));
    }
}