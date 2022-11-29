<?php
declare(strict_types=1);

namespace QVGDS\Game\Service;

use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameId;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Session\Domain\SessionNotFoundException;
use QVGDS\Session\Domain\SessionsRepository;

final class GamesService
{
    public function __construct(private readonly SessionsRepository $sessions)
    {
    }

    public function start(GameId $id, SessionId $sessionId): Game
    {
        $session = $this->sessions->get($sessionId);
        if ($session === null) {
            throw new SessionNotFoundException();
        }

        return Game::start($id, $session);
    }
}
