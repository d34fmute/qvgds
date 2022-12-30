<?php
declare(strict_types=1);

namespace App\Http\Controllers\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\Joker\Joker;
use QVGDS\Game\Domain\Joker\JokerStatus;
use QVGDS\Game\Domain\Joker\JokerType;

#[Schema(title: "Joker", description: "Joker type and status")]
final class RestJoker
{
    private function __construct(
        #[Property]
        private readonly JokerType   $type,
        #[Property]
        private readonly JokerStatus $status
    )
    {
    }

    public function getType(): string
    {
        return $this->type->name;
    }

    public function getStatus(): string
    {
        return $this->status->name;
    }

    public static function from(Joker $joker): self
    {
        return new self($joker->type(), $joker->status());
    }

    /**
     * @return RestJoker[]
     */
    public static function fromGame(Game $game): array
    {
        return array_map(
            fn(Joker $joker): RestJoker => RestJoker::from($joker),
            $game->jokers()->all()
        );
    }
}
