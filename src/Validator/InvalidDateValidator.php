<?php

namespace App\Validator;

class InvalidDateValidator
{
    public function validate(array $record): ?string
    {
        $date = trim($record['service_date'] ?? '');
        if ($date === '') return null;

        $d = \DateTime::createFromFormat('Y-m-d', $date);
        if (!$d || $d->format('Y-m-d') !== $date) {
            return "Invalid date format: $date";
        }
        if ($d > new \DateTime()) {
            return "Service date is in the future: $date";
        }
        return null;
    }
}