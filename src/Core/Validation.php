<?php

namespace quiz\Core;

class Validation
{
    public array $errors = [];
    public array $uInput;
    public bool $anyErrors = false;

    public function __construct(array $uInput)
    {
        $this->uInput = $uInput;
        $this->anyErrors = $this->checkRequired($uInput);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function checkRequired(array $uInput): bool
    {
        $gotError = false;
        // Catching params that must be checked on "required"
        foreach ($uInput as $paramName => $ruleName) {
            if (stripos('required', $ruleName) !== false) {
                // Catching errors & switching error state
                if (empty($_POST[$paramName])) {
                    $this->errors[$paramName] = ucfirst($paramName) . " lauks ir obligāts!";
                    $gotError = true;
                }
            }
        }
        return $gotError;
    }
}