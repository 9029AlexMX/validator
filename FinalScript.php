<?php

namespace App;

require_once('autoload.php');

use App\Validation\Factory\FileValidatorCollectionFactory;

class FinalScript
{
    private int $scenario = 1;

    public function run(): void
    {
        $file = new FileEntity();
        $file->metadata['file_size'] = '0';

        // Assume we retrieved validator configuration for tenant from DB.
        // Assume validation configuration is stored as (validatorId, config). Config is compressed.
        // But decompression is done anywhere else. Just for simplicity.
        $configDb = [
            ['validatorId' => 1, 'config' => []],
            ['validatorId' => 2, 'config' => ['bytes' => '1024']],
            ['validatorId' => 3, 'config' => ['field' => 'tenant_id']],
        ];

        $this->runScenario($file, $configDb);

        $file = new FileEntity();
        $file->content = '... previous text. BADWoRD. Next text...';
        $file->metadata['file_size'] = '2048';
        $configDb = [
            ['validatorId' => 1, 'config' => []],
            ['validatorId' => 2, 'config' => ['bytes' => '1024']],
            ['validatorId' => 3, 'config' => ['field' => 'tenant_id']],
            ['validatorId' => 4, 'config' => ['words' => ['badword','rude']]],
        ];
        $this->runScenario($file, $configDb);

        $file = new FileEntity();
        $file->content = '... previous text. Ryde BDWoRD. Next text...';
        $file->metadata['file_size'] = '1024';
        $file->metadata['tenant_id'] = '123';
        $configDb = [
            ['validatorId' => 2, 'config' => ['bytes' => '1024']],
            ['validatorId' => 3, 'config' => ['field' => 'tenant_id']],
            ['validatorId' => 4, 'config' => ['words' => ['badword','rude']]],
        ];
        $this->runScenario($file, $configDb);
    }

    private function runScenario(FileEntity $file, array $configDb): void
    {
        $validator = (new FileValidatorCollectionFactory())->createFromConfig($configDb);

        $result = $validator->validate($file);

        echo '------------ SCENARIO ' . $this->scenario . ' ------------' . PHP_EOL;
        echo 'File is ' . ($result->isValid ? '' : 'not ') . 'valid.' . PHP_EOL;

        if (!$result->isValid) {
            echo 'Next errors are found:' . PHP_EOL;
            foreach ($result->getErrors() as $error) {
                echo $error . PHP_EOL;
            }
        }
        echo PHP_EOL;

        $this->scenario++;
    }
}

(new FinalScript())->run();
