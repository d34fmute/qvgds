<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QVGDS\Game\Domain\Fail;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\Joker\Joker;
use QVGDS\Game\Domain\ShitCoins;
use QVGDS\Game\Service\GamesManager;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\Question;
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

    public function get(string $gameId): Response
    {
        $game = $this->getGame($gameId);

        return new JsonResponse($this->serialize($game));
    }

    /**
     * @return array<string, mixed>
     */
    private function serialize(Game $game): array
    {
        return [
            "id" => $game->id()->get(),
            "player" => $game->player(),
            "step" => $game->step(),
            "shitcoins" => $game->shitCoins()->amount(),
            "status" => $game->status(),
            "jokers" => [$this->serializeJokers($game)]
        ];
    }

    public function list(): Response
    {
        $games = $this->games->list();
        $json = array_map(
            fn(Game $game): array => $this->serializeWithQuestions($game),
            $games
        );
        return new JsonResponse($json);
    }

    public function currentQuestion(string $gameId): Response
    {
        $game = $this->getGame($gameId);

        $currentQuestion = $game->currentQuestion();

        $json = [
            "reward" => ShitCoins::fromLevel($game->step(), $game->status())->amount(),
            "step" => $game->step(),
            "question" => $currentQuestion->text(),
            "answers" => $this->serializeAnswers($currentQuestion),
        ];

        return new JsonResponse($json);
    }

    public function guess(Request $request, string $gameId): Response
    {
        $answer = $request->json()->get("answer");

        $gameOrFail = $this->games->guess(new GameId(Uuid::fromString($gameId)), new Answer($answer));

        if ($gameOrFail instanceof Fail) {
            return new JsonResponse(
                [
                    "shitcoins" => $gameOrFail->game->shitCoins()->amount(),
                    "goodAnswer" => $gameOrFail->game->currentQuestion()->goodAnswer()->text,
                    "gameStatus" => $gameOrFail->game->status()->value
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        return $this->currentQuestion($gameId);
    }

    public function fiftyFifty(string $gameId): Response
    {
        $answers = $this->games->fiftyFifty(new GameId(Uuid::fromString($gameId)));

        $json = array_map(fn(Answer $a): string => $a->text, $answers);
        return new JsonResponse(["badAnswers" => $json]);
    }

    /**
     * @return array<string, mixed>
     */
    private function serializeWithQuestions(Game $game): array
    {
        return [
            "id" => $game->id()->get(),
            "player" => $game->player(),
            "step" => $game->step(),
            "status" => $game->status(),
            "questions" => [
                array_map(
                    fn(Question $q): array => ["question" => $q->text(), "answers" => $this->serializeAnswers($q)],
                    $game->session()->questions()
                )
            ]
        ];
    }

    public function jokers(string $gameId): Response
    {
        $game = $this->getGame($gameId);
        $jokers = $this->serializeJokers($game);

        return new JsonResponse($jokers);
    }

    private function getGame(string $gameId): Game
    {
        return $this->games->get(new GameId(Uuid::fromString($gameId)));
    }

    private function serializeJoker(): \Closure
    {
        return fn(Joker $joker): array => [
            "type" => $joker->type(),
            "status" => $joker->status()
        ];
    }

    public function forgive(string $gameId): Response
    {
        $game = $this->games->forgive(new GameId(Uuid::fromString($gameId)));

        return new JsonResponse($this->serialize($game));
    }

    private function serializeJokers(Game $game): array
    {
        return array_map(
            $this->serializeJoker(),
            $game->jokers()->all()
        );
    }

    private function serializeAnswers(Question $question): array
    {
        $answers = [$question->goodAnswer(), ...$question->badAnswers()];
        shuffle($answers);

        return array_map(fn(Answer $a): array => ["answer" => $a->text], $answers);
    }

}
