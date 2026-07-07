<?php

namespace App\Validation;

use App\FileEntity;

class FileMetadataFieldValidator extends FileValidatorSingleRuleAbstract
{
    private string $field;

    public function __construct(array $config)
    {
        if (!isset($config['field'])) {
            throw new \RuntimeException('Metadata field to validate is not known.');
        }
        $this->field = $config['field'];
    }

    public function validate(FileEntity $file): FileValidatorResult
    {
        $result = new FileValidatorResult();

        $error = '';
        if (!isset($file->metadata[$this->field])) {
            $error = 'Metadata field `' . $this->field . '` is not set.';
        } elseif (!$file->metadata[$this->field]) {
            $error = 'Metadata field `' . $this->field . '` has empty value.';
        }

        if ($error) {
            $result->addError($error);
            $this->addParentResultError($error);
        }

        return $result;
    }
}
