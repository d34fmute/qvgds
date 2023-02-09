<?php
declare(strict_types=1);

namespace Session\Domain\Question;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Utils\MissingMandatoryValueException;

final class AnswerTest extends TestCase
{
    #[Test]
    public function shouldNotBuildWithEmptyText(): void
    {
        self::expectException(MissingMandatoryValueException::class);
        self::expectExceptionMessage("text");

        new Answer("");
    }
}
