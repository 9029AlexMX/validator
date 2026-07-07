<?php

namespace App\Validation\Factory;

use App\Validation\FileValidatorInterface;

interface FileValidatorFactoryInterface
{
    public function createFromConfig(array $config): FileValidatorInterface;
}
