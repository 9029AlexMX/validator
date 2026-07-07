<?php

namespace App\Validation\Tests\Factory;

use App\Validation\FileValidatorResult;
use PHPUnit\Framework\TestCase;

class FileValidatorResultTest extends TestCase
{
    public function testAddError(): void
    {
        $sut = new FileValidatorResult();
        $this->assertCount(0, $sut->getErrors());

        $sut->addError('Error 1');
        $this->assertSame([
            'Error 1',
        ], $sut->getErrors());

        $sut->addError('Error 2');
        $this->assertSame([
            'Error 1',
            'Error 2',
        ], $sut->getErrors());
    }
}
