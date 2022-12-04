<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameBlockedException;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\GameStatus;
use QVGDS\Game\Domain\Joker\Jokers;
use QVGDS\Game\Domain\ShitCoins;
use QVGDS\Session\Domain\Question\Answer;
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

        new Game(GameId::newId(), "Toto", new Jokers(), SessionFixtures::sessionWithQuestions(), GameStatus::IN_PROGRESS, -1);
    }

    /**
     * @test
     */
    public function shouldListAvailableJokers(): void
    {
        $game = GameFixtures::newGame();

        $this->assertCount(3, $game->availableJokers());
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

        $this->assertCount(2, $game->fiftyFifty(1));

        self::assertCount(2, $game->availableJokers());
    }

    /**
     * @test
     */
    public function shouldForgiveAGame(): void
    {
        $game = GameFixtures::newGame();

        $game->forgive();

        self::assertEquals(GameStatus::FORGIVEN, $game->status());
    }

    /**
     * @test
     */
    public function shouldLooseWithABadAnswer(): void
    {
        $game = GameFixtures::newGame();

        $game->guess(new Answer("You loose"));

        self::assertEquals(GameStatus::LOST, $game->status());
    }

    /**
     * @test
     */
    public function shouldFailWhenGuessingOnLostGame(): void
    {
        $lostGame = new Game(GameFixtures::gameId(), "Toto", new Jokers(), SessionFixtures::sessionWithQuestions(), GameStatus::LOST, 4);
        $this->expectException(GameBlockedException::class);
        $this->expectExceptionMessage("Game LOST");
        $lostGame->guess(new Answer("don’t care"));
    }

    /**
     * @test
     */
    public function shouldFailWhenGuessingOnForgivenGame(): void
    {
        $forgivenGame = new Game(GameFixtures::gameId(), "Toto", new Jokers(), SessionFixtures::sessionWithQuestions(), GameStatus::FORGIVEN, 4);
        $this->expectException(GameBlockedException::class);
        $this->expectExceptionMessage("Game FORGIVEN");
        $forgivenGame->guess(new Answer("don’t care"));
    }
}
