<?php

namespace App\Validation\Tests\Factory;

use App\FileEntity;
use App\Validation\FileProhibitedWordsValidator;
use App\Validation\FileValidatorResult;
use PHPUnit\Framework\TestCase;

class FileProhibitedWordsValidatorTest extends TestCase
{
    public function testConstructWordsNotSet(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Prohibited words should be set.');
        new FileProhibitedWordsValidator(['whatever' => 'else']);
    }

    public function testConstructWordsEmpty(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Prohibited words should be set.');
        new FileProhibitedWordsValidator(['words']);
    }

    public function testConstructWordsNotArray(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Prohibited words should be words list.');
        new FileProhibitedWordsValidator(['words' => 'a']);
    }

    public function testConstructWordsNotWord(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Prohibited words should be words list.');
        new FileProhibitedWordsValidator(['words' => ['a', ['a']]]);
    }

    public function testValidateFails(): void
    {
        $file = new FileEntity();
        $file->content = '... previous text. Badword. Text continues..';

        $parentResult = new FileValidatorResult();
        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileProhibitedWordsValidator(['words' => ['badword', 'anotherbadword']]);
        $sut->setParentResult($parentResult);
        $result = $sut->validate($file);

        $this->assertFalse($result->isValid);
        $this->assertSame([
            'There are prohibited words in file.',
        ], $result->getErrors());

        $this->assertFalse($parentResult->isValid);
        $this->assertSame([
            'There are prohibited words in file.',
        ], $parentResult->getErrors());
    }

    public function testValidateOk(): void
    {
        $file = new FileEntity();
        $file->content = '... previous text. Bdword. Anotherbdword. Text continues..';

        $parentResult = new FileValidatorResult();
        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());

        $sut = new FileProhibitedWordsValidator(['words' => ['badword', 'anotherbadword']]);
        $sut->setParentResult($parentResult);
        $result = $sut->validate($file);

        $this->assertTrue($result->isValid);
        $this->assertSame([], $result->getErrors());

        $this->assertTrue($parentResult->isValid);
        $this->assertSame([], $parentResult->getErrors());
    }
}
