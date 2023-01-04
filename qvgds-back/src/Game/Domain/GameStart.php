<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

use QVGDS\Session\Domain\SessionId;

final readonly class GameStart
{

    public function __construct(public GameId $gameId, public SessionId $sessionId, public string $player)
    {
    }
}
