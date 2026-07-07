<?php

namespace App\Validation\Tests\Factory;

use App\FileEntity;
use App\Validation\FileNotEmptyValidator;
use App\Validation\FileValidatorResult;
use PHPUnit\Framework\TestCase;

class FileValidatorSingleRuleAbstractTest extends TestCase
{
    public function testAddParentResultError(): void
    {
        $parentResult = new FileValidatorResult();

        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileNotEmptyValidator();
        $sut->addParentResultError('Error 1');

        // Noting changed.
        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileNotEmptyValidator();
        $sut->setParentResult($parentResult);
        $sut->addParentResultError('Error 1');

        $this->assertFalse($parentResult->isValid);
        $this->assertSame(['Error 1'], $parentResult->getErrors());

        $sut = new FileNotEmptyValidator();
        $sut->setParentResult($parentResult);
        $sut->addParentResultError('Error 2');

        $this->assertFalse($parentResult->isValid);
        $this->assertSame(['Error 1', 'Error 2'], $parentResult->getErrors());
    }
}
