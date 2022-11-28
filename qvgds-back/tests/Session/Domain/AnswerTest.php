<?php
declare(strict_types=1);

namespace Session\Domain;

use PHPUnit\Framework\TestCase;
use QVGDS\Session\Domain\Answer;
use QVGDS\Utils\MissingMandatoryValueException;

final class AnswerTest extends TestCase
{
    /**
    * @test
    */
    public function shouldNotBuildWithEmptyText(): void
    {
        self::expectException(MissingMandatoryValueException::class);
        self::expectExceptionMessage("text");

        new Answer("");
    }
}