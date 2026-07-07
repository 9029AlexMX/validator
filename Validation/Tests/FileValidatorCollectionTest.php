<?php

namespace App\Validation\Tests\Factory;

use App\FileEntity;
use App\Validation\FileMetadataFieldValidator;
use App\Validation\FileNotEmptyValidator;
use App\Validation\FileValidatorCollection;
use App\Validation\FileValidatorResult;
use PHPUnit\Framework\TestCase;

class FileValidatorCollectionTest extends TestCase
{
    public function testValidateEmpty(): void
    {
        $file = new FileEntity();
        $sut = new FileValidatorCollection();
        $result = $sut->validate($file);

        $this->assertTrue($result->isValid);
        $this->assertSame([], $result->getErrors());
    }

    public function testValidateRuntimeException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Metadata field to validate is not known.');

        $file = new FileEntity();
        $sut = new FileValidatorCollection([
            new FileNotEmptyValidator(),
            new FileMetadataFieldValidator([]),
        ]);
        $sut->validate($file);
    }

    public function testValidateErrors(): void
    {
        $file = new FileEntity();

        $sut = new FileValidatorCollection([
            new FileNotEmptyValidator(),
            new FileMetadataFieldValidator(['field' => 'author']),
        ]);
        $result = $sut->validate($file);

        $this->assertFalse($result->isValid);
        $this->assertSame([
            'File is empty.',
            'Metadata field `author` is not set.',
        ], $result->getErrors());
    }

    public function testValidateOk(): void
    {
        $file = new FileEntity();
        $file->content = 'somecontent';
        $file->metadata['author'] = 'Alexey';

        $sut = new FileValidatorCollection([
            new FileNotEmptyValidator(),
            new FileMetadataFieldValidator(['field' => 'author']),
        ]);
        $result = $sut->validate($file);

        $this->assertTrue($result->isValid);
        $this->assertSame([], $result->getErrors());
    }
}
