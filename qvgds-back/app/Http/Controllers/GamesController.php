<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Attributes\BadRequest;
use App\Http\Controllers\DTO\RestGame;
use App\Http\Controllers\DTO\RestJoker;
use App\Http\Controllers\DTO\RestStartGame;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use QVGDS\Game\Domain\Fail;
use QVGDS\Game\Domain\Game;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\ShitCoins;
use QVGDS\Game\Service\GamesManager;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\Question;
use QVGDS\Session\Domain\SessionId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final readonly class GamesController
{
    private Serializer $serializer;

    public function __construct(private GamesManager $games)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new GetSetMethodNormalizer(), new PropertyNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    #[OA\Post(
        path: "/api/games",
        description: "Start a game",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(type: RestStartGame::class)
        ),
        tags: ["Games"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Game summary",
                content: new OA\JsonContent(type: RestGame::class)
            ),
            new BadRequest()
        ]
    )]
    public function start(Request $request): Response
    {
        /** @var RestStartGame $restStartGame */
        $restStartGame = $this->serializer->deserialize($request->getContent(), RestStartGame::class, "json");

        $game = $this->games->start(
            GameId::newId(),
            new SessionId(Uuid::fromString($restStartGame->session)),
            $restStartGame->player
        );

        return new JsonResponse(
            $this->serializer->normalize(RestGame::from($game))
        );
    }

    #[OA\Get(
        path: "/api/games/{gameId}",
        description: "Game details",
        tags: ["Games"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Game summary",
                content: new OA\JsonContent(type: RestGame::class)
            ),
            new OA\Response(
                response: 404,
                description: "Game not found"
            )
        ]
    )]
    public function get(
        #[OA\PathParameter(schema: new OA\Schema(type: "uuid"))]
        string $gameId
    ): Response
    {
        return new JsonResponse(
            $this->serializer->normalize(RestGame::from($this->getGame($gameId)))
        );
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

        return new JsonResponse($this->serializer->normalize(RestJoker::fromGame($game)));
    }

    private function getGame(string $gameId): Game
    {
        return $this->games->get(new GameId(Uuid::fromString($gameId)));
    }

    public function forgive(string $gameId): Response
    {
        $game = $this->games->forgive(new GameId(Uuid::fromString($gameId)));

        return new JsonResponse($this->serializer->normalize(RestGame::from($game)));
    }

    private function serializeAnswers(Question $question): array
    {
        $answers = [$question->goodAnswer(), ...$question->badAnswers()];
        shuffle($answers);

        return array_map(fn(Answer $a): array => ["answer" => $a->text], $answers);
    }

}
