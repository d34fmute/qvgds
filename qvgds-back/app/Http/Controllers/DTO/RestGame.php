<?php
declare(strict_types=1);

namespace App\Http\Controllers\DTO;

use OpenApi\Attributes as OA;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameStatus;

#[OA\Schema(
    title: "Game",
    description: "Game representation"
)]
final readonly class RestGame
{

    /**
     * @param RestJoker[] $jokers
     */
    private function __construct(
        #[OA\Property]
        public string     $id,

        #[OA\Property]
        public string     $player,

        #[OA\Property]
        public int        $step,

        #[OA\Property]
        public int        $shitcoins,

        #[OA\Property]
        public GameStatus $status,

        #[OA\Property(items: new OA\Items(type: RestJoker::class))]
        public array      $jokers
    )
    {
    }

    public static function from(Game $game): self
    {
        return new self(
            $game->id()->get(),
            $game->player(),
            $game->step(),
            $game->shitCoins()->amount(),
            $game->status(),
            RestJoker::fromGame($game)
        );
    }
}
