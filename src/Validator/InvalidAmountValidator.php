<?php

namespace App\Validator;

class InvalidAmountValidator
{
    public function validate(array $record): ?string
    {
        $billed = floatval($record['billed_amount'] ?? 0);
        $reimbursed = floatval($record['reimbursed_amount'] ?? 0);

        if ($billed <= 0) {
            return "Billed amount must be greater than zero: $billed";
        }
        if ($reimbursed < 0) {
            return "Reimbursed amount cannot be negative: $reimbursed";
        }
        return null;
    }
}