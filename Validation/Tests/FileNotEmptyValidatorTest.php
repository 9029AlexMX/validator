<?php
namespace App\Validation\Tests\Factory;

use App\FileEntity;
use App\Validation\FileNotEmptyValidator;
use App\Validation\FileValidatorResult;
use PHPUnit\Framework\TestCase;

class FileNotEmptyValidatorTest extends TestCase
{
    public function testValidateEmptyFile(): void
    {
        $file = new FileEntity();
        $sut = new FileNotEmptyValidator();
        $result = $sut->validate($file);

        $this->assertFalse($result->isValid);
        $this->assertSame([
            'File is empty.'
        ], $result->getErrors());
    }

    public function testValidateOk(): void
    {
        $file = new FileEntity();
        $file->content = 'somecontent';

        $parentResult = new FileValidatorResult();
        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileNotEmptyValidator();
        $sut->setParentResult($parentResult);
        $result = $sut->validate($file);

        $this->assertTrue($result->isValid);
        $this->assertSame([], $result->getErrors());

        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());
    }
}

?>