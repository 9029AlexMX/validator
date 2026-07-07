<?php
namespace App\Validation\Tests\Factory;

use App\Validation\FileMaximumSizeValidator;
use App\Validation\FileMetadataFieldValidator;
use App\Validation\FileNotEmptyValidator;
use App\Validation\Factory\FileValidatorCollectionFactory;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Before; 

class FileValidatorCollectionFactoryTest extends TestCase
{
    private FileValidatorCollectionFactory $sut;

    #[Before]
    protected function setSut(): void
    {
        $this->sut = new FileValidatorCollectionFactory();
    }

    public function testCreateFromConfigInvalid(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Validator id is not set.');
        $validatorCollection = $this->sut->createFromConfig(['a']);
    }

    public function testCreateFromConfigEmpty(): void
    {
        $validatorCollection = $this->sut->createFromConfig([]);
        $this->assertSame(0, $validatorCollection->rules->count());
    }

    public function testCreateFromConfigOk(): void
    {
        $validatorCollection = $this->sut->createFromConfig([
            ['validatorId' => 1, 'config' => []],
            ['validatorId' => 2, 'config' => ['bytes' => '1024']],
            ['validatorId' => 3, 'config' => ['field' => 'tenant_id']],
        ]);
        $this->assertSame(3, $validatorCollection->rules->count());
        $this->assertInstanceOf(FileNotEmptyValidator::class, $validatorCollection->rules[0]);
        $this->assertInstanceOf(FileMaximumSizeValidator::class, $validatorCollection->rules[1]);
        $this->assertInstanceOf(FileMetadataFieldValidator::class, $validatorCollection->rules[2]);
    }
}

?>