<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\ShitCoins;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\QuestionId;
use QVGDS\Tests\Game\GameFixtures;
use QVGDS\Tests\Session\SessionFixtures;

final class GameTest extends TestCase
{
    /**
    * @test
    */
    public function shouldListAvailableJokers(): void
    {
        $game = GameFixtures::newGame();

        $this->assertCount(2, $game->jokers());
    }

    /**
    * @test
    */
    public function shouldIncrementScoreWithAGoodAnswer(): void
    {
        $game = GameFixtures::newGame();

        $game->guess(SessionFixtures::questionId(), new Answer("Good answer"));

        $this->assertEquals(ShitCoins::of(100), $game->shitCoins());
    }

    /**
    * @test
    */
    public function shouldRevealTwoBadAnswersWithFiftyFifty(): void
    {
        $game = GameFixtures::newGame();

        $this->assertCount(2, $game->fiftyFifty(new QuestionId(1)));

        self::assertCount(1, $game->jokers());
    }
}
