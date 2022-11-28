<?php
declare(strict_types=1);

namespace QVGDS\Tests\Session\Service;

use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Session\Domain\SessionsRepository;


final class TestInMemorySessionsRepository implements SessionsRepository
{

    /**
     * @var Session[]
     */
    private array $sessions = [];

    public function __construct()
    {
    }

    public function save(Session $session): Session
    {
        $this->sessions[$session->id()->toString()] = $session;

        return $session;
    }

    public function get(SessionId $id): Session
    {
        return $this->sessions[$id->toString()];
    }
}