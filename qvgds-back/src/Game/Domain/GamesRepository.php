<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

interface GamesRepository
{
    public function save(Game $game): void;
    public function get(GameId $id): ?Game;

    /**
     * @return Game[]
     */
    public function list(): array;

}
