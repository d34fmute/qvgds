<?php
declare(strict_types=1);

namespace App\Http\Controllers\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

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
}
