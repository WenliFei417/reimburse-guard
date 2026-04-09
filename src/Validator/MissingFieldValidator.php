<?php

namespace App\Validator;

class MissingFieldValidator
{
    private array $required = [
        'record_id', 'patient_id', 'provider_name',
        'service_date', 'claim_type', 'billed_amount', 'reimbursed_amount'
    ];

    public function validate(array $record): ?string
    {
        foreach ($this->required as $field) {
            if (!isset($record[$field]) || trim((string)$record[$field]) === '') {
                return "Missing required field: $field";
            }
        }
        return null;
    }
}