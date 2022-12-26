<?php
declare(strict_types=1);

namespace App\Http\Controllers\DTO;

use OpenApi\Attributes as OA;
use OpenApi\Attributes\Property;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameStatus;
use QVGDS\Game\Domain\Joker\Joker;

#[OA\Schema(
    title: "Game",
    description: "Game representation"
)]
final class RestGame
{
    /**
     * @var RestJoker[]
     */
    #[Property]
    public readonly array $jokers;

    /**
     * @param RestJoker[] $jokers
     */
    private function __construct(
        #[Property]
        public readonly string     $id,

        #[Property]
        public readonly string     $player,

        #[Property]
        public readonly int        $step,

        #[Property]
        public readonly int        $shitcoins,

        #[Property]
        public readonly GameStatus $status,

        array                      $jokers
    )
    {
        $this->jokers = $jokers;
    }

    public static function from(Game $game): self
    {
        return new self(
            $game->id()->get(),
            $game->player(),
            $game->step(),
            $game->shitCoins()->amount(),
            $game->status(),
            self::serializeJokers($game)
        );
    }

    private static function serializeJokers(Game $game): array
    {
        return array_map(
            fn(Joker $joker): RestJoker => RestJoker::from($joker),
            $game->jokers()->all()
        );
    }
}
