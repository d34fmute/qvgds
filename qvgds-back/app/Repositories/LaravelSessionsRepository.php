<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\LaravelQuestion;
use App\Models\LaravelSession;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\BadAnswers;
use QVGDS\Session\Domain\Question\GoodAnswer;
use QVGDS\Session\Domain\Question\Question;
use QVGDS\Session\Domain\Question\QuestionId;
use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Session\Domain\SessionsRepository;
use Ramsey\Uuid\Uuid;

final class LaravelSessionsRepository implements SessionsRepository
{

    public function save(Session $session): Session
    {
        LaravelSession::upsert(
            [
                "id" => $session->id()->get(),
                "name" => $session->name(),
            ],
            ["id"],
            ["name"]
        );

        $this->upsertQuestions($session->questions(), $session->id());

        return $session;
    }

    public function get(SessionId $id): ?Session
    {
        $laravelSession = LaravelSession::find($id->get());
        if ($laravelSession === null) {
            return null;
        }

        return LaravelSessionsRepository::toDomain($laravelSession);
    }

    /**
     * @inheritDoc
     */
    public function list(): array
    {
        return LaravelSession::all()->map(fn(LaravelSession $s): Session => LaravelSessionsRepository::toDomain($s))
            ->toArray();
    }

    public static function toDomain(LaravelSession $laravelSession): Session
    {
        $questions = $laravelSession->questions()->get()->map(
            fn(LaravelQuestion $q): Question => new Question(
                new QuestionId(Uuid::fromString($q->id)),
                $q->step,
                $q->question,
                new GoodAnswer(new Answer($q->good_answer)),
                new BadAnswers(
                    new Answer($q->bad_answer1),
                    new Answer($q->bad_answer2),
                    new Answer($q->bad_answer3)
                )
            )
        );

        return new Session(
            new SessionId(Uuid::fromString($laravelSession->id)),
            $laravelSession->name,
            ...$questions
        );
    }

    private function toLaravelQuestion(Question $question, SessionId $sessionId)
    {
        LaravelQuestion::upsert(
            [
                "id" => $question->id()->get(),
                "session" => $sessionId->get(),
                "step" => $question->step(),
                "question" => $question->text(),
                "good_answer" => $question->goodAnswer(),
                "bad_answer1" => $question->badAnswers()[0]->text,
                "bad_answer2" => $question->badAnswers()[1]->text,
                "bad_answer3" => $question->badAnswers()[2]->text,
            ],
            ["id"],
            [
                "session",
                "step",
                "question",
                "good_answer",
                "bad_answer1",
                "bad_answer2",
                "bad_answer3"
            ]
        );
    }

    /**
     * @param Question[] $questions
     */
    private function upsertQuestions(array $questions, SessionId $sessionId)
    {
        array_walk($questions, fn(Question $question) => $this->toLaravelQuestion($question, $sessionId));
    }
}
