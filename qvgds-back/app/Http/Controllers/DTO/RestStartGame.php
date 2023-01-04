<?php
declare(strict_types=1);

namespace App\Http\Controllers\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\GameStart;
use QVGDS\Session\Domain\SessionId;

#[Schema(
    title: "Game start",
    description: "Parameters to start a game"
)]
final readonly class RestStartGame
{
    public function __construct(
        #[Property]
        public string $session,
        #[Property]
        public string $player
    )
    {
    }

    public function toDomain(): GameStart
    {
        return new GameStart(GameId::newId(), SessionId::from($this->session), $this->player);
    }
}
