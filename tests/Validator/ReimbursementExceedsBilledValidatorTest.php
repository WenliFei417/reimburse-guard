<?php

namespace App\Tests\Validator;

use App\Validator\ReimbursementExceedsBilledValidator;
use PHPUnit\Framework\TestCase;

class ReimbursementExceedsBilledValidatorTest extends TestCase
{
    private ReimbursementExceedsBilledValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new ReimbursementExceedsBilledValidator();
    }

    public function testNormalAmountPasses(): void
    {
        $this->assertNull($this->validator->validate([
            'billed_amount' => '1000',
            'reimbursed_amount' => '800',
        ]));
    }

    public function testEqualAmountPasses(): void
    {
        $this->assertNull($this->validator->validate([
            'billed_amount' => '1000',
            'reimbursed_amount' => '1000',
        ]));
    }

    public function testReimbursedExceedsBilledFails(): void
    {
        $this->assertNotNull($this->validator->validate([
            'billed_amount' => '500',
            'reimbursed_amount' => '600',
        ]));
    }
}