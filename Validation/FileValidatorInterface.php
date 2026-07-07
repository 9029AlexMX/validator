<?php

namespace App\Validation;

use App\FileEntity;

interface FileValidatorInterface
{
    public function validate(FileEntity $file): FileValidatorResult;
}

?>