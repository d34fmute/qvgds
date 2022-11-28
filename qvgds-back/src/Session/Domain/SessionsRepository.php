<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;

interface SessionsRepository
{
    public function save(Session $session): Session;

    public function get(SessionId $id): Session|null;

}