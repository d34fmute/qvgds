<?php
declare(strict_types=1);

namespace QVGDS\Tests\Game;

use QVGDS\Game\Domain\Game;
use QVGDS\Tests\Session\SessionFixtures;

final class GameFixtures
{
    public static function newGame(): Game
    {
        return Game::start(SessionFixtures::sessionWithQuestions());
    }
}
