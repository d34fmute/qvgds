<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

use QVGDS\Utils\Assert;

final class Question
{

    public function __construct(
        private readonly QuestionId $id,
        private readonly string $text,
        private readonly GoodAnswer $goodAnswer,
        private readonly BadAnswers $badAnswers,
    )
    {
        Assert::notEmptyText("text", $text);
    }

    /**
     * @return Answer[]
     */
    public function fiftyFifty(): array
    {
        return $this->badAnswers->fiftyFifty();
    }

    public function guess(Answer $guess): bool
    {
        return $this->goodAnswer->text == $guess;
    }

    public function id(): QuestionId
    {
        return $this->id;
    }

    public function text(): string
    {
        return $this->text;
    }
}
