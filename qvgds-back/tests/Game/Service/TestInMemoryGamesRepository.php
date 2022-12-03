<?php
declare(strict_types=1);

namespace QVGDS\Tests\Game\Service;

use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\GamesRepository;

final class TestInMemoryGamesRepository implements GamesRepository
{

    private array $games = [];

    public function __construct()
    {
    }

    public function get(GameId $id): ?Game
    {
        $key = $id->id->toString();
        if (!array_key_exists($key, $this->games)) {
            return null;
        }
        return $this->games[$key];
    }

    public function save(Game $game): void
    {
        $this->games[$game->id()->id->toString()] = $game;
    }

    /**
     * @inheritDoc
     */
    public function list(): array
    {
        return array_values($this->games);
    }
}
