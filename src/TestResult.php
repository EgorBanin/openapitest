<?php declare(strict_types=1);

namespace openapitest;

class TestResult
{
    private $errors = [];

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function addError($message)
    {
        $this->errors[] = $message;
    }
}