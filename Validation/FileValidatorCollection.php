<?php
namespace App\Validation;

use App\FileEntity;

/**
 * Validates file with rules collection.
 */
class FileValidatorCollection implements FileValidatorInterface
{
    public \Traversable $rules;

    public function __construct(array $rules=[])
    {
        $this->rules = new \ArrayIterator($rules);
    }

    public function validate(FileEntity $file): FileValidatorResult
    {
        $result = new FileValidatorResult();

        foreach ($this->rules as $validator) {
            $validator->setParentResult($result);
            $validator->validate($file);
        }

        return $result;
    }
}

?>