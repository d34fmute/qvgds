<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

use QVGDS\Session\Domain\Question\QuestionNotFoundException;
use QVGDS\Utils\Assert;

final class Session
{
    /**
     * @var Question[]
     */
    private array $questions;

    public function __construct(private readonly SessionId $id, private readonly string $name, Question ...$questions)
    {
        Assert::notEmptyText("session name", $name);
        $this->questions = $questions;
    }

    public function id(): SessionId
    {
        return $this->id;
    }

    public function add(QuestionToAdd $question): void
    {
        $index = count($this->questions) +1;
        $this->questions[] = new Question(new QuestionId($index), $question->text, $question->goodAnswer, $question->badAnswers);
    }

    public function questions(): array
    {
        return $this->questions;
    }

    public function guess(QuestionId $id, Answer $answer): bool
    {
        $pop = $this->findQuestion($id);

        return $pop->guess($answer);
    }

    /**
     * @return Question[]
     */
    public function fiftyFifty(QuestionId $id): array
    {
        return $this->findQuestion($id)->fiftyFifty();
    }

    private function findQuestion(QuestionId $id): Question
    {
        $questions = array_filter($this->questions, fn(Question $q): bool => $q->id() == $id);
        if (empty($questions)) {
            throw new QuestionNotFoundException((string) $id->id);
        }

        return array_pop($questions);
    }
}