<?php
namespace App\Validation;

class FileValidatorResult
{
    public bool $isValid = true;

    private array $errorMessages = [];

    public function addError($errorText): void
    {
        $this->isValid = false;
        $this->errorMessages[] = $errorText;
    }

    public function getErrors(): array
    {
        return $this->errorMessages;
    }
}

?>