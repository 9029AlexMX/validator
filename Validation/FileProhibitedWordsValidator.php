<?php
namespace App\Validation;

use App\FileEntity;

class FileProhibitedWordsValidator extends FileValidatorSingleRuleAbstract
{
    private array $words;

    public function __construct(array $config)
    {
        if(empty($config['words'])) {
            throw new \RuntimeException('Prohibited words should be set.');
        }
        if(!is_array($config['words'])) {
            throw new \RuntimeException('Prohibited words should be words list.');
        }
        foreach($config['words'] as $word) {
            if (!is_string($word)) {
                throw new \RuntimeException('Prohibited words should be words list.');
            }
        }
        $this->words = $config['words'];
    }

    public function validate(FileEntity $file): FileValidatorResult
    {
        $result = new FileValidatorResult();

        $words = implode('|', $this->words);
        if (preg_match('/'.$words.'/i', $file->content)) {
            $error = 'There are prohibited words in file.';
            $result->addError($error);
            $this->addParentResultError($error);
        }

        return $result;
    }
}

?>