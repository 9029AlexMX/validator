<?php

namespace App\Validation;

use App\FileEntity;

class FileMaximumSizeValidator extends FileValidatorSingleRuleAbstract
{
    private int $bytes;

    public function __construct(array $config)
    {
        if (!isset($config['bytes'])) {
            throw new \RuntimeException('Maximum file size is not known.');
        }
        $this->bytes = $config['bytes'];
    }

    public function validate(FileEntity $file): FileValidatorResult
    {
        $result = new FileValidatorResult();

        $error = '';
        // Lets assume `file_size` is stored in bytes always.
        if (!isset($file->metadata['file_size'])) {
            $error = 'File has no file size specified in metadata.';
        } elseif ($file->metadata['file_size'] > $this->bytes) {
            $error = 'File size exceeds ' . $this->bytes . ' bytes.';
        }

        if ($error) {
            $result->addError($error);
            $this->addParentResultError($error);
        }

        return $result;
    }
}
