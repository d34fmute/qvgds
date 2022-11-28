<?php
declare(strict_types=1);

namespace QVGDS\Tests\Session;

use QVGDS\Session\Domain\Answer;
use QVGDS\Session\Domain\BadAnswers;
use QVGDS\Session\Domain\GoodAnswer;
use QVGDS\Session\Domain\Question;
use QVGDS\Session\Domain\QuestionId;
use QVGDS\Session\Domain\QuestionToAdd;
use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
use Ramsey\Uuid\Uuid;

final class SessionFixtures
{

    public static function sessionId(): SessionId
    {
        return new SessionId(Uuid::fromString("1c272363-bc86-4cc0-b401-a389fbcbcb14"));
    }

    public static function questionId(): QuestionId
    {
        return new QuestionId(1);
    }

    public static function goodAnswer(): GoodAnswer
    {
        return new GoodAnswer(new Answer("Good answer"));
    }

    public static function badAnswers(): BadAnswers
    {
        return new BadAnswers(
            new Answer("bad answer 1"),
            new Answer("bad answer 2"),
            new Answer("bad answer 3"),
        );
    }

    public static function question(): Question
    {
        return new Question(self::questionId(), self::questionText(), self::goodAnswer(), self::badAnswers());
    }

    public static function sessionWithoutQuestions(): Session
    {
        return new Session(SessionFixtures::sessionId(), self::sessionName());
    }

    public static function sessionWithQuestions(): Session
    {
        return new Session(SessionFixtures::sessionId(), self::sessionName(), self::question());
    }

    public static function questionToAdd(): QuestionToAdd
    {
        return new QuestionToAdd(self::questionText(), self::goodAnswer(), self::badAnswers());
    }

    private static function questionText(): string
    {
        return "The question";
    }

    private static function sessionName(): string
    {
        return "Session name";
    }
}