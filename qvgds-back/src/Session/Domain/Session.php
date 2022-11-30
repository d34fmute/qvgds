<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\Question;
use QVGDS\Session\Domain\Question\QuestionId;
use QVGDS\Session\Domain\Question\QuestionNotFoundException;
use QVGDS\Session\Domain\Question\QuestionToAdd;
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
        $this->questions[] = new Question($this->calculateQuestionId(), $question->text, $question->goodAnswer, $question->badAnswers);
    }

    /**
     * @return Question[]
     */
    public function questions(): array
    {
        return $this->questions;
    }

    public function guess(QuestionId $id, Answer $answer): bool
    {
        return $this->findQuestion($id)->guess($answer);
    }

    /**
     * @return Answer[]
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

    private function calculateQuestionId(): QuestionId
    {
        $index = count($this->questions) + 1;
        return new QuestionId($index);
    }
}
