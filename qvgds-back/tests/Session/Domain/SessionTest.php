<?php

declare(strict_types=1);

namespace Session\Domain;

use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\Level;
use QVGDS\Session\Domain\Question\QuestionNotFoundException;
use QVGDS\Session\Domain\Session;
use QVGDS\Tests\Session\SessionFixtures;
use QVGDS\Utils\MissingMandatoryValueException;

class SessionTest extends TestCase
{
    #[Test]
    public function shouldNotBuildWithEmptyPlayers(): void
    {
        $this->expectException(MissingMandatoryValueException::class);
        $this->expectExceptionMessage("session name");

        new Session(SessionFixtures::sessionId(), "");
    }

    #[Test]
    public function shouldAddAQuestionWithAnIncrementalId(): void
    {
        $session = SessionFixtures::sessionWithoutQuestions();

        $question = SessionFixtures::questionToAdd();

        $session->add($question);
        self::assertEquals([SessionFixtures::question()], $session->questions());
    }

    #[Test]
    public function shouldHaveAnErrorWhenQuestionIsNotFound(): void
    {
        $session = SessionFixtures::sessionWithQuestions();

        $this->expectException(QuestionNotFoundException::class);
        $this->expectExceptionMessage("Question 3 not found in this session");

        $session->fiftyFifty(Level::THREE);
    }
}
