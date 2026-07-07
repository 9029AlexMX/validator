<?php

namespace App\Validation\Factory;

use App\Validation\FileValidatorSingleRuleAbstract;

abstract class FileValidatorSingleRuleFactoryAbstract implements FileValidatorFactoryInterface
{
    /**
     * Probably this is unneeded complexity.
     * Looks like current way of single rule validator creation, that is implemetned in FileValidatorSingleRuleFactory class
     * is enough. But still if we will need some more complex logic for validator creation it can be redefined with new
     * FileValidatorSingleRuleFactoryAbstract implementation.
     */
    private const ID_VALIDATOR_TO_FACTORY_MAP = [
        1 => FileValidatorSingleRuleFactory::class,
        2 => FileValidatorSingleRuleFactory::class,
        3 => FileValidatorSingleRuleFactory::class,
        4 => FileValidatorSingleRuleFactory::class,
    ];

    abstract public function createFromConfig(array $config): FileValidatorSingleRuleAbstract;

    public static function createFactory(int $validatorId): FileValidatorSingleRuleFactoryAbstract
    {
        if (!isset(self::ID_VALIDATOR_TO_FACTORY_MAP[$validatorId])) {
            throw new \RuntimeException('Please specify factory for validator id `' . $validatorId . '`.');
        }
        return new (self::ID_VALIDATOR_TO_FACTORY_MAP[$validatorId])();
    }
}
