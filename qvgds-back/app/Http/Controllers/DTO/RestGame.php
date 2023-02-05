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
        private string     $id,

        #[OA\Property]
        private string     $player,

        #[OA\Property]
        private int        $level,

        #[OA\Property]
        private int        $shitcoins,

        #[OA\Property]
        private GameStatus $status,

        #[OA\Property(items: new OA\Items(type: RestJoker::class))]
        private array      $jokers
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPlayer(): string
    {
        return $this->player;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getShitcoins(): int
    {
        return $this->shitcoins;
    }

    public function getStatus(): string
    {
        return $this->status->name;
    }

    public function getJokers(): array
    {
        return $this->jokers;
    }


    public static function from(Game $game): self
    {
        return new self(
            $game->id()->get(),
            $game->player(),
            $game->step()->value,
            $game->shitCoins()->amount(),
            $game->status(),
            RestJoker::fromGame($game)
        );
    }
}
