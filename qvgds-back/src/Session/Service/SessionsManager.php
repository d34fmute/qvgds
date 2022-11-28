<?php
declare(strict_types=1);

namespace QVGDS\Session\Service;

use QVGDS\Session\Domain\Question\QuestionToAdd;
use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Session\Domain\SessionNotFoundException;
use QVGDS\Session\Domain\SessionsRepository;

final class SessionsManager
{

    public function __construct(private readonly SessionsRepository $sessions)
    {
    }

    public function create(SessionId $sessionId, string $name): Session
    {
        return $this->sessions->save(new Session($sessionId, $name));
    }

    public function get(SessionId $sessionId): Session
    {
        $session = $this->sessions->get($sessionId);
        if ($session === null) {
            throw new SessionNotFoundException();
        }

        return $session;
    }

    public function addQuestion(SessionId $sessionId, QuestionToAdd $questionToAdd): Session
    {
        $session = $this->get($sessionId);

        $session->add($questionToAdd);

        $this->sessions->save($session);

        return $session;
    }
}
