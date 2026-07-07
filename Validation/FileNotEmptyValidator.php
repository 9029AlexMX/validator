<?php

namespace App\Validation;

use App\FileEntity;

class FileNotEmptyValidator extends FileValidatorSingleRuleAbstract
{
    public function validate(FileEntity $file): FileValidatorResult
    {
        $result = new FileValidatorResult();

        if (!$file->content) {
            $error = 'File is empty.';
            $result->addError($error);
            $this->addParentResultError($error);
        }

        return $result;
    }
}
