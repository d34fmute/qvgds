<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameBlockedException;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\GameStatus;
use QVGDS\Game\Domain\Joker\Jokers;
use QVGDS\Game\Domain\Level;
use QVGDS\Game\Domain\ShitCoins;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Tests\Game\GameFixtures;
use QVGDS\Tests\Session\SessionFixtures;

final class GameTest extends TestCase
{
    #[Test]
    public function shouldIncrementScoreWithAGoodAnswer(): void
    {
        $game = GameFixtures::newGame();

        $game->guess(new Answer("Good answer"));

        $this->assertEquals(ShitCoins::ONE_HUNDRED, $game->shitCoins());
    }

    #[Test]
    public function shouldForgiveAGame(): void
    {
        $game = GameFixtures::newGame();

        $game->forgive();

        self::assertEquals(GameStatus::FORGIVEN, $game->status());
    }

    #[Test]
    public function shouldLooseWithABadAnswer(): void
    {
        $game = GameFixtures::newGame();

        $fail = $game->guess(new Answer("You loose"));

        self::assertEquals(GameStatus::LOST, $fail->game->status());
    }

    #[Test]
    public function shouldFailWhenGuessingOnLostGame(): void
    {
        $lostGame = new Game(GameFixtures::gameId(), "Toto", new Jokers(), SessionFixtures::sessionWithQuestions(), GameStatus::LOST, Level::FOUR);
        $this->expectException(GameBlockedException::class);
        $this->expectExceptionMessage("Game LOST");
        $lostGame->guess(new Answer("don’t care"));
    }

    #[Test]
    public function shouldFailWhenGuessingOnForgivenGame(): void
    {
        $forgivenGame = new Game(GameFixtures::gameId(), "Toto", new Jokers(), SessionFixtures::sessionWithQuestions(), GameStatus::FORGIVEN, Level::FOUR);
        $this->expectException(GameBlockedException::class);
        $this->expectExceptionMessage("Game FORGIVEN");
        $forgivenGame->guess(new Answer("don’t care"));
    }

    #[Test]
    public function gameStartedShouldHaveZeroShitcoin(): void
    {
        $game = GameFixtures::newGame();

        self::assertEquals(ShitCoins::ZERO, $game->shitCoins());
    }

    #[Test]
    public function shouldHaveShitcoinsForFirstThreshold(): void
    {
        $game = new Game(
            GameId::newId(),
            GameFixtures::player(),
            new Jokers(),
            SessionFixtures::sessionWithQuestions(),
            GameStatus::LOST,
            Level::EIGHT
        );

        self::assertEquals($game->shitCoins(), ShitCoins::ONE_THOUSAND);
    }

    #[Test]
    public function shouldHaveShitcoinsForSecondThreshold(): void
    {
        $game = new Game(
            GameId::newId(),
            GameFixtures::player(),
            new Jokers(),
            SessionFixtures::sessionWithQuestions(),
            GameStatus::LOST,
            Level::TWELVE
        );

        self::assertEquals($game->shitCoins(), ShitCoins::TWENTY_FOUR_THOUSAND);
    }
}
