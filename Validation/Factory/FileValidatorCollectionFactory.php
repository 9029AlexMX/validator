<?php
namespace App\Validation\Factory;

use App\Validation\FileValidatorCollection;

class FileValidatorCollectionFactory implements FileValidatorFactoryInterface
{
    public function createFromConfig(array $config): FileValidatorCollection
    {
        $validatorCollection = new FileValidatorCollection();

        foreach ($config as $singleRuleConfig) {
            if(!isset($singleRuleConfig['validatorId'])) {
                throw new \RuntimeException('Validator id is not set.');
            }

            $factory = FileValidatorSingleRuleFactoryAbstract::createFactory($singleRuleConfig['validatorId']);
            $validator = $factory->createFromConfig($singleRuleConfig);
            $validatorCollection->rules->append($validator);
        }

        return $validatorCollection;
    }
}

?>