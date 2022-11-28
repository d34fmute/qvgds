<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

final class QuestionToAdd
{

    public function __construct(public readonly string $text, public readonly GoodAnswer $goodAnswer, public readonly BadAnswers $badAnswers)
    {
    }
}
