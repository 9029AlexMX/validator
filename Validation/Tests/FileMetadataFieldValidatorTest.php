<?php
namespace App\Validation\Tests\Factory;

use App\FileEntity;
use App\Validation\FileMetadataFieldValidator;
use App\Validation\FileValidatorResult;
use PHPUnit\Framework\TestCase;

class FileMetadataFieldValidatorTest extends TestCase
{
    public function testConstructBytesFieldUnknown(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Metadata field to validate is not known.');
        new FileMetadataFieldValidator(['whatever' => 'else']);
    }

    public function testValidateFieldNotSet(): void
    {
        $file = new FileEntity();
        $sut = new FileMetadataFieldValidator(['field' => 'author']);
        $result = $sut->validate($file);

        $this->assertFalse($result->isValid);
        $this->assertSame([
            'Metadata field `author` is not set.'
        ], $result->getErrors());
    }

    public function testValidateFieldEmpty(): void
    {
        $file = new FileEntity();
        $file->metadata['author'] = '';

        $parentResult = new FileValidatorResult();
        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileMetadataFieldValidator(['field' => 'author']);
        $sut->setParentResult($parentResult);
        $result = $sut->validate($file);

        $this->assertFalse($result->isValid);
        $this->assertSame([
            'Metadata field `author` has empty value.'
        ], $result->getErrors());

        $this->assertFalse($parentResult->isValid);
        $this->assertSame([
            'Metadata field `author` has empty value.'
        ], $parentResult->getErrors());
    }

    public function testValidateOk(): void
    {
        $file = new FileEntity();
        $file->metadata['author'] = 'Alexey';

        $parentResult = new FileValidatorResult();
        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileMetadataFieldValidator(['field' => 'author']);
        $sut->setParentResult($parentResult);
        $result = $sut->validate($file);

        $this->assertTrue($result->isValid);
        $this->assertSame([], $result->getErrors());

        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());
    }
}

?>