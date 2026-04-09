<?php

namespace App\Validator;

class ReimbursementExceedsBilledValidator
{
    public function validate(array $record): ?string
    {
        $billed = floatval($record['billed_amount'] ?? 0);
        $reimbursed = floatval($record['reimbursed_amount'] ?? 0);

        if ($reimbursed > $billed) {
            return "Reimbursed amount ($reimbursed) exceeds billed amount ($billed)";
        }
        return null;
    }
}