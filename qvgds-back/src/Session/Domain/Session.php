<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

use QVGDS\Game\Domain\Level;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\Question;
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

    public function name(): string
    {
        return $this->name;
    }

    public function add(QuestionToAdd $question): void
    {
        $this->questions[] = new Question($question->id, $this->calculateStep(), $question->text, $question->goodAnswer, $question->badAnswers);
    }

    /**
     * @return Question[]
     */
    public function questions(): array
    {
        return $this->questions;
    }

    public function guess(Level $level, Answer $answer): bool
    {
        return $this->findQuestion($level)->guess($answer);
    }

    /**
     * @return Answer[]
     */
    public function fiftyFifty(Level $level): array
    {
        return $this->findQuestion($level)->fiftyFifty();
    }

    private function findQuestion(Level $level): Question
    {
        $questions = array_filter($this->questions, fn(Question $q): bool => $q->level() == $level);
        if (empty($questions)) {
            throw new QuestionNotFoundException((string)$level->value);
        }

        return array_pop($questions);
    }

    private function calculateStep(): Level
    {
        return Level::from(count($this->questions));
    }

    public function question(Level $level): Question
    {
        return $this->findQuestion($level);
    }
}
