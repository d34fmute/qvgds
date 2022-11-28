<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SessionId
{
    public function __construct(public readonly UuidInterface $id)
    {
    }

    public static function newId(): self
    {
        return new SessionId(Uuid::uuid4());
    }

    public function toString(): string
    {
        return $this->id->toString();
    }
}