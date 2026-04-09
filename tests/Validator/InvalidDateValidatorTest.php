<?php

namespace App\Tests\Validator;

use App\Validator\InvalidDateValidator;
use PHPUnit\Framework\TestCase;

class InvalidDateValidatorTest extends TestCase
{
    private InvalidDateValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new InvalidDateValidator();
    }

    public function testValidDatePasses(): void
    {
        $this->assertNull($this->validator->validate(['service_date' => '2024-03-01']));
    }

    public function testFutureDateFails(): void
    {
        $this->assertNotNull($this->validator->validate(['service_date' => '2099-01-01']));
    }

    public function testInvalidFormatFails(): void
    {
        $this->assertNotNull($this->validator->validate(['service_date' => '03/01/2024']));
    }

    public function testEmptyDateSkips(): void
    {
        $this->assertNull($this->validator->validate(['service_date' => '']));
    }
}