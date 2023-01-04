<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

use QVGDS\Utils\Assert;

final readonly class Question
{
    public function __construct(
        private QuestionId $id,
        private int        $step,
        private string     $text,
        private GoodAnswer $goodAnswer,
        private BadAnswers $badAnswers,
    )
    {
        Assert::notEmptyText("text", $text);
        Assert::numberValue("step", $step)->isEqualOrGreaterThan(1);
        $this->assertGoodAnswerIsNotInBadAnswers($goodAnswer, $badAnswers);
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
        return $this->goodAnswer->get() == $guess;
    }

    public function id(): QuestionId
    {
        return $this->id;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function goodAnswer(): Answer
    {
        return $this->goodAnswer->get();
    }

    /**
     * @return Answer[]
     */
    public function badAnswers(): array
    {
        return $this->badAnswers->get();
    }

    public function step(): int
    {
        return $this->step;
    }

    private function assertGoodAnswerIsNotInBadAnswers(GoodAnswer $goodAnswer, BadAnswers $badAnswers): void
    {
        if (in_array($goodAnswer->get(), $badAnswers->get())) {
            throw new GoodAnswerIsAlsoInBadAnswersException();
        }
    }
}
