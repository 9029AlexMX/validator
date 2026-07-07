<?php
namespace App\Validation\Tests\Factory;

use App\FileEntity;
use App\Validation\FileMaximumSizeValidator;
use App\Validation\FileValidatorResult;
use PHPUnit\Framework\TestCase;

class FileMaximumSizeValidatorTest extends TestCase
{
    public function testConstructBytesUnknown(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Maximum file size is not known.');
        new FileMaximumSizeValidator(['whatever' => 'else']);
    }

    public function testValidateFileHasNoMetadata(): void
    {
        $file = new FileEntity();
        $sut = new FileMaximumSizeValidator(['bytes' => '256']);
        $result = $sut->validate($file);

        $this->assertFalse($result->isValid);
        $this->assertSame([
            'File has no file size specified in metadata.'
        ], $result->getErrors());
    }

    public function testValidateSizeExceeds(): void
    {
        $file = new FileEntity();
        $file->metadata['file_size'] = '257';

        $parentResult = new FileValidatorResult();
        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileMaximumSizeValidator(['bytes' => '256']);
        $sut->setParentResult($parentResult);
        $result = $sut->validate($file);

        $this->assertFalse($result->isValid);
        $this->assertSame([
            'File size exceeds 256 bytes.'
        ], $result->getErrors());

        $this->assertFalse($parentResult->isValid);
        $this->assertSame([
            'File size exceeds 256 bytes.'
        ], $parentResult->getErrors());
    }

    public function testValidateSizeOk(): void
    {
        $file = new FileEntity();
        $file->metadata['file_size'] = '256';

        $parentResult = new FileValidatorResult();
        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileMaximumSizeValidator(['bytes' => '256']);
        $sut->setParentResult($parentResult);
        $result = $sut->validate($file);

        $this->assertTrue($result->isValid);
        $this->assertSame([], $result->getErrors());

        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());
    }
}

?>