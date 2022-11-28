<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

use QVGDS\Utils\Assert;

final class Answer
{

    public function __construct(public readonly string $text)
    {
        Assert::notEmptyText("text", $text);
    }
}
