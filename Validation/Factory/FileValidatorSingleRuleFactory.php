<?php
namespace App\Validation\Factory;

use App\Validation\FileMaximumSizeValidator;
use App\Validation\FileMetadataFieldValidator;
use App\Validation\FileNotEmptyValidator;
use App\Validation\FileProhibitedWordsValidator;
use App\Validation\FileValidatorSingleRuleAbstract;

class FileValidatorSingleRuleFactory extends FileValidatorSingleRuleFactoryAbstract
{
    /**
     * We need to store validation configuration somehow for each tenant. This can
     * be done in many ways. But I prefer to have short integer value to be associated
     * with each possible validation. In such way we reduce amount of data stored in
     * database, because to store integer we need less place than for string.
     */
    private const DB_VALUE_TO_CLASS_MAP = [
        1 => FileNotEmptyValidator::class,
        2 => FileMaximumSizeValidator::class,
        3 => FileMetadataFieldValidator::class,
        4 => FileProhibitedWordsValidator::class,
    ];
    
    public function createFromConfig(array $config): FileValidatorSingleRuleAbstract
    {
        if(!isset($config['validatorId'])) {
            throw new \RuntimeException('Validator id is not set.');
        }
        // We can set it to empty array if key is not set, but I think it is correct to require it to be set,
        // so developer will not forget to set it.
        if(!isset($config['config'])) {
            throw new \RuntimeException('Validator config is not set.');
        }

        $validatorId = $config['validatorId'];
        if (!isset(self::DB_VALUE_TO_CLASS_MAP[$validatorId])) {
            throw new \RuntimeException('Unknown validator id `'.$validatorId.'`.');
        }
        return new (self::DB_VALUE_TO_CLASS_MAP[$validatorId])($config['config']);
    }
}

?>