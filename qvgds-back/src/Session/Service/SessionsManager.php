<?php
declare(strict_types=1);

namespace QVGDS\Session\Service;

use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
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
        return $this->sessions->get($sessionId);
    }
}