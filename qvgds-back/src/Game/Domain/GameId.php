<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class GameId
{
    public function __construct(public readonly UuidInterface $id)
    {
    }

    public static function newId(): self
    {
        return new self(Uuid::uuid4());
    }

}
