<?php
declare(strict_types=1);

namespace QVGDS\Tests\Game;

use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\GameStart;
use QVGDS\Tests\Session\SessionFixtures;
use Ramsey\Uuid\Uuid;

final class GameFixtures
{
    public static function newGame(): Game
    {
        return Game::start(self::gameId(), self::player(), SessionFixtures::sessionWithQuestions());
    }

    public static function gameId(): GameId
    {
        return new GameId(Uuid::fromString("7cb03186-5430-45c2-9bdb-d5993a4ad209"));
    }

    public static function player(): string
    {
        return "Toto";
    }

    public static function gameStart(): GameStart
    {
        return new GameStart(self::gameId(), SessionFixtures::sessionId(), self::player());
    }
}
