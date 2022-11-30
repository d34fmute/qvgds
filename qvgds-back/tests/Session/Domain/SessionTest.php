<?php

declare(strict_types=1);

namespace Session\Domain;

use PHPUnit\Framework\TestCase;
use QVGDS\Session\Domain\Question\QuestionId;
use QVGDS\Session\Domain\Question\QuestionNotFoundException;
use QVGDS\Session\Domain\Session;
use QVGDS\Tests\Session\SessionFixtures;
use QVGDS\Utils\MissingMandatoryValueException;

class SessionTest extends TestCase
{
    /**
    * @test
    */
    public function shouldNotBuildWithEmptyPlayers(): void
    {
        $this->expectException(MissingMandatoryValueException::class);
        $this->expectExceptionMessage("session name");

        new Session(SessionFixtures::sessionId(), "");
    }

    /**
    * @test
    */
    public function shouldAddAQuestionWithAnIncrementalId(): void
    {
        $session = SessionFixtures::sessionWithoutQuestions();

        $question = SessionFixtures::questionToAdd();

        $session->add($question);
        self::assertEquals([SessionFixtures::question()], $session->questions());
    }

    /**
    * @test
    */
    public function shouldHaveAnErrorWhenQuestionIsNotFound(): void
    {
        $session = SessionFixtures::sessionWithQuestions();

        $this->expectException(QuestionNotFoundException::class);
        $this->expectExceptionMessage("Question 3 not found in this session");

        $session->fiftyFifty(new QuestionId(3));
    }
}
