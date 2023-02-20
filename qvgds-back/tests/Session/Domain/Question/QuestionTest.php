<?php

namespace Session\Domain\Question;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\Level;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\BadAnswers;
use QVGDS\Session\Domain\Question\GoodAnswerIsAlsoInBadAnswersException;
use QVGDS\Session\Domain\Question\Question;
use QVGDS\Tests\Session\SessionFixtures;
use QVGDS\Utils\MissingMandatoryValueException;

class QuestionTest extends TestCase
{
    #[Test]
    public function shouldNoBuildWithEmptyText()
    {
        self::expectException(MissingMandatoryValueException::class);
        self::expectExceptionMessage("text");

        new Question(SessionFixtures::questionId(), Level::EIGHT, "", SessionFixtures::goodAnswer(), SessionFixtures::badAnswers());
    }

    #[Test]
    public function shouldHaveGoodAnswerDifferentOfBadAnswers(): void
    {
        $this->expectException(GoodAnswerIsAlsoInBadAnswersException::class);

        new Question(SessionFixtures::questionId(), Level::FOURTEEN, "toto", SessionFixtures::goodAnswer(), new BadAnswers(new Answer("Good answer"), new Answer("bad"), new Answer("bad")));
    }

    #[Test]
    public function shouldAskForFiftyFifty(): void
    {
        $question = new Question(SessionFixtures::questionId(), Level::ONE, "toto", SessionFixtures::goodAnswer(), SessionFixtures::badAnswers());

        $answers = $question->fiftyFifty();

        self::assertContainsOnlyInstancesOf(Answer::class, $answers);
        self::assertCount(2, $answers);
        self::assertNotEquals($answers[0], $answers[1]);
    }

    #[Test]
    public function shouldVerifyGoodAnswer(): void
    {
        $question = new Question(SessionFixtures::questionId(), Level::ONE, "toto", SessionFixtures::goodAnswer(), SessionFixtures::badAnswers());

        self::assertTrue($question->guess(new Answer("Good answer")));
    }

    #[Test]
    public function shouldVerifyBadAnswer(): void
    {
        $question = new Question(SessionFixtures::questionId(), Level::FOUR, "toto", SessionFixtures::goodAnswer(), SessionFixtures::badAnswers());

        self::assertFalse($question->guess(new Answer("Bad answer")));
    }
}
