<?php
namespace App\Validation;

use App\FileEntity;

/**
 * Abstract class for file validation with single rule.
 */
abstract class FileValidatorSingleRuleAbstract implements FileValidatorInterface
{
    /**
     * Result of validation with rules collection.
     * Can be `null` if validation should be executed out of collection scope.
     * If set, then found errors will be added to rules collection validation result as well.
     */
    private ?FileValidatorResult $parentResult = null;

    public function __construct(array $config=[])
    {
    }

    public function addParentResultError(string $errorMessage): void
    {
        if (!$this->parentResult) {
            return;
        }

        $this->parentResult->isValid = false;
        $this->parentResult->addError($errorMessage);
    }

    public function setParentResult(FileValidatorResult $parentResult): void
    {
        $this->parentResult = $parentResult;
    }

    abstract public function validate(FileEntity $file): FileValidatorResult;
}

?>