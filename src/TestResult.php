<?php declare(strict_types=1);

namespace openapitest;

class TestResult
{
    private $errors = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function addError($message)
    {
        $this->errors[] = $message;
    }
}