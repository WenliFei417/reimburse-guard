<?php

namespace App\Validator;

class DuplicateRecordValidator
{
    private array $seen = [];

    public function validate(array $record): ?string
    {
        $key = ($record['patient_id'] ?? '') . '|' .
               ($record['service_date'] ?? '') . '|' .
               ($record['claim_type'] ?? '');

        if (isset($this->seen[$key])) {
            return "Duplicate record: patient_id + service_date + claim_type already exists";
        }
        $this->seen[$key] = true;
        return null;
    }
}