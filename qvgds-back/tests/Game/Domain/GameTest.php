<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\Joker\Jokers;
use QVGDS\Game\Domain\ShitCoins;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\QuestionId;
use QVGDS\Tests\Game\GameFixtures;
use QVGDS\Tests\Session\SessionFixtures;
use QVGDS\Utils\InvalidNumberArgumentException;

final class GameTest extends TestCase
{
    /**
    * @test
    */
    public function shouldNotBuildWithANegativeStep(): void
    {
        $this->expectException(InvalidNumberArgumentException::class);
        $this->expectExceptionMessage("step must be equal or greater than 0");

        new Game(GameId::newId(), new Jokers(), SessionFixtures::sessionWithQuestions(), -1 );
    }
    /**
    * @test
    */
    public function shouldListAvailableJokers(): void
    {
        $game = GameFixtures::newGame();

        $this->assertCount(3, $game->jokers());
    }

    /**
    * @test
    */
    public function shouldIncrementScoreWithAGoodAnswer(): void
    {
        $game = GameFixtures::newGame();

        $game->guess(new Answer("Good answer"));

        $this->assertEquals(ShitCoins::of(100), $game->shitCoins());
    }

    /**
    * @test
    */
    public function shouldRevealTwoBadAnswersWithFiftyFifty(): void
    {
        $game = GameFixtures::newGame();

        $this->assertCount(2, $game->fiftyFifty(new QuestionId(1)));

        self::assertCount(2, $game->jokers());
    }
}
