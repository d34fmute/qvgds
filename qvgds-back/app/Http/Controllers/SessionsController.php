<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\BadAnswers;
use QVGDS\Session\Domain\Question\GoodAnswer;
use QVGDS\Session\Domain\Question\Question;
use QVGDS\Session\Domain\Question\QuestionId;
use QVGDS\Session\Domain\Question\QuestionToAdd;
use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Session\Domain\SessionNotFoundException;
use QVGDS\Session\Service\SessionsManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SessionsController
{
    public function __construct(private readonly SessionsManager $sessions)
    {
    }

    public function list(): Response
    {
        $sessions = $this->sessions->list();

        return new JsonResponse(array_map(fn(Session $session): array => SessionsController::serializeSession($session), $sessions));
    }

    public function index(): View
    {
        $this->sessions->list();

        return view('session.index');
    }

    // Display form
    public function create(Request $request): Response
    {
        $name = $request->json()->get("name");

        $sessionId = SessionId::newId();
        $session = $this->sessions->create($sessionId, $name);

        return new JsonResponse(SessionsController::serializeSession($session), Response::HTTP_CREATED);
    }

    public function show(string $id): Response
    {
        try {
            $session = $this->sessions->get(new SessionId(Uuid::fromString($id)));
        } catch (SessionNotFoundException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(SessionsController::serializeSession($session));
    }

    public function addQuestion(Request $request, string $sessionId): Response
    {
        $json = $request->json();
        $text = $json->get("text");
        $goodAnswer = $json->get("goodAnswer");
        $badAnswer1 = $json->get("badAnswer1");
        $badAnswer2 = $json->get("badAnswer2");
        $badAnswer3 = $json->get("badAnswer3");

        $session = $this->sessions->addQuestion(SessionId::from($sessionId), new QuestionToAdd(QuestionId::newId(), $text, new GoodAnswer(new Answer($goodAnswer)), new BadAnswers(new Answer($badAnswer1), new Answer($badAnswer2), new Answer($badAnswer3))));

        return new JsonResponse(SessionsController::serializeSession($session));
    }

    /**
     * @return array<string, string>
     */
    public static function serializeSession(Session $session): array
    {
        return [
            "id" => $session->id()->id->toString(),
            "name" => $session->name(),
            "questions" => array_map(fn(Question $question): array => self::serializeQuestion($question), $session->questions())
        ];
    }

    private static function serializeQuestion(Question $question): array
    {
        return [
            "id" => $question->id()->get(),
            "text" => $question->text(),
            "step" => $question->level(),
            "goodAnswer" => $question->goodAnswer()->text,
            "badAnswers" => array_map(fn(Answer $answer): string => $answer->text, $question->badAnswers())
        ];
    }

}
