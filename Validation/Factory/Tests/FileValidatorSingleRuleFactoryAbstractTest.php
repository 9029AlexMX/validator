<?php
namespace App\Validation\Tests\Factory;

use App\Validation\Factory\FileValidatorSingleRuleFactory;
use App\Validation\Factory\FileValidatorSingleRuleFactoryAbstract;
use PHPUnit\Framework\TestCase;

class FileValidatorSingleRuleFactoryAbstractTest extends TestCase
{
    public function testCreateFactoryUnknown(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Please specify factory for validator id `999999999`.');
        FileValidatorSingleRuleFactoryAbstract::createFactory(999999999);
    }

    public function testCreateFactoryFileMaximumSizeValidator(): void
    {
        $factory = FileValidatorSingleRuleFactoryAbstract::createFactory(3);
        $this->assertInstanceOf(FileValidatorSingleRuleFactory::class, $factory);
    }

    public function testCreateFactoryFileMetadataFieldValidator(): void
    {
        $factory = FileValidatorSingleRuleFactoryAbstract::createFactory(2);
        $this->assertInstanceOf(FileValidatorSingleRuleFactory::class, $factory);
    }

    public function testCreateFactoryFileNotEmptyValidator(): void
    {
        $factory = FileValidatorSingleRuleFactoryAbstract::createFactory(1);
        $this->assertInstanceOf(FileValidatorSingleRuleFactory::class, $factory);
    }

    public function testCreateFactoryFileProhibitedWordsValidator(): void
    {
        $factory = FileValidatorSingleRuleFactoryAbstract::createFactory(4);
        $this->assertInstanceOf(FileValidatorSingleRuleFactory::class, $factory);
    }
}

?>