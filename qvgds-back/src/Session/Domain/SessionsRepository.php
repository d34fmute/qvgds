<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

interface SessionsRepository
{
    public function save(Session $session): Session;

    public function get(SessionId $id): ?Session;

    /**
     * @return Session[]
     */
    public function list(): array;
}
