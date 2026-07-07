<?php

namespace App\Validation\Tests\Factory;

use App\Validation\FileMaximumSizeValidator;
use App\Validation\FileMetadataFieldValidator;
use App\Validation\FileNotEmptyValidator;
use App\Validation\FileProhibitedWordsValidator;
use App\Validation\Factory\FileValidatorSingleRuleFactory;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Before;

class FileValidatorSingleRuleFactoryTest extends TestCase
{
    private FileValidatorSingleRuleFactory $sut;

    #[Before]
    protected function setSut(): void
    {
        $this->sut = new FileValidatorSingleRuleFactory();
    }

    public function testCreateFromConfigValidatorIdNotSet(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Validator id is not set.');
        $this->sut->createFromConfig(['a']);
    }

    public function testCreateFromConfigConfigdNotSet(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Validator config is not set.');
        $this->sut->createFromConfig(['validatorId' => 1]);
    }

    public function testCreateFromConfigUnknownValidator(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unknown validator id `9999999999`.');
        $this->sut->createFromConfig(['validatorId' => 9999999999, 'config' => []]);
    }
    public function testCreateFromConfigFileMaximumSizeValidator(): void
    {
        $validator = $this->sut->createFromConfig(['validatorId' => 2, 'config' => ['bytes' => '1']]);
        $this->assertInstanceOf(FileMaximumSizeValidator::class, $validator);
    }

    public function testCreateFromConfigFileMetadataFieldValidator(): void
    {
        $validator = $this->sut->createFromConfig(['validatorId' => 3, 'config' => ['field' => 'whatever']]);
        $this->assertInstanceOf(FileMetadataFieldValidator::class, $validator);
    }

    public function testCreateFromConfigFileNotEmptyValidator(): void
    {
        $validator = $this->sut->createFromConfig(['validatorId' => 1, 'config' => []]);
        $this->assertInstanceOf(FileNotEmptyValidator::class, $validator);
    }

    public function testCreateFromConfigFileProhibitedWordsValidator(): void
    {
        $validator = $this->sut->createFromConfig(['validatorId' => 4, 'config' => ['words' => ['a']]]);
        $this->assertInstanceOf(FileProhibitedWordsValidator::class, $validator);
    }
}
