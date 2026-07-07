<?php
namespace App;

require_once('autoload.php');

use App\Validation\Factory\FileValidatorCollectionFactory;

class FinalScript
{
    public function run(): void
    {
        $file = new FileEntity();
        $file->metadata['file_size'] = '2048';

        // Assume we retrieved validator configuration for tenant from DB.
        // Assume validation configuration is stored as (validatorId, config). Config is compressed.
        // But decompression is done anywhere else. Just for simplicity.
        $collectionDb = [
            ['validatorId' => 1, 'config' => []],
            ['validatorId' => 2, 'config' => ['bytes' => '1024']],
            ['validatorId' => 3, 'config' => ['field' => 'tenant_id']],
        ];
        $validator = (new FileValidatorCollectionFactory)->createFromConfig($collectionDb);

        $result = $validator->validate($file);
        
        echo 'File is '.($result->isValid ? '' : 'not ').'valid.'.PHP_EOL;

        if (!$result->isValid) {
            echo 'Next errors are found:'.PHP_EOL;
            foreach ($result->getErrors() as $error) {
                echo $error.PHP_EOL;
            }
        }
    }
}

(new FinalScript)->run();

?>