<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Service\GamesManager;
use QVGDS\Session\Domain\SessionId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GamesController
{
    public function __construct(private readonly GamesManager $games)
    {
    }

    public function start(Request $request): Response
    {
        $session = $request->json()->get("session");
        $player = $request->json()->get("player");

        $game = $this->games->start(GameId::newId(), new SessionId(Uuid::fromString($session)), $player);

        return new JsonResponse($this->serialize($game));
    }

    /**
     * @return array<string, string>
     */
    private function serialize(Game $game): array
    {
        return [
            "id" => $game->id()->get(),
            "player" => $game->player()
        ];
    }

    public function list(): Response
    {
        $games = $this->games->list();
        $json = array_map(
            fn(Game $game): array => $this->serializeWithSession($game),
            $games
        );
        return new JsonResponse($json);
    }

    /**
     * @return array<string, mixed>
     */
    private function serializeWithSession(Game $game): array
    {
        return [
            "id" => $game->id()->get(),
            "player" => $game->player(),
            "step" => $game->step(),
            "status" => $game->status()->name,
            "session" => [
                SessionsController::serializeSession($game->session())
            ]
        ];
    }

    public function jokers(string $gameId): Response
    {
        $game = $this->games->get(new GameId(Uuid::fromString($gameId)));

        return new JsonResponse([$game->availableJokers()]);
    }

}
