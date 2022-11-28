<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\Joker\Jokers;
use QVGDS\Session\Domain\Answer;
use QVGDS\Session\Domain\QuestionId;
use QVGDS\Tests\Session\SessionFixtures;

final class GameTest extends TestCase
{
    /**
    * @test
    */
    public function shouldListAvailableJokers(): void
    {
        $game = new Game(new Jokers(), SessionFixtures::sessionWithQuestions());

        $this->assertCount(2, $game->jokers());
    }

    /**
    * @test
    */
    public function shouldIncrementScoreWithAGoodAnswer(): void
    {
        $game = new Game(new Jokers(), SessionFixtures::sessionWithQuestions());

        $game->guess(SessionFixtures::questionId(), new Answer("Good answer"));

        $this->assertEquals(1, $game->score());
    }

    /**
    * @test
    */
    public function shouldRevealTwoBadAnswersWithFiftyFifty(): void
    {
        $game = new Game(new Jokers(), SessionFixtures::sessionWithQuestions());

        $this->assertCount(2, $game->fiftyFifty(new QuestionId(1)));

        self::assertCount(1, $game->jokers());
    }
}