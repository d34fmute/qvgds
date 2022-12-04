<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class QuestionId
{
    public function __construct(public readonly UuidInterface $id)
    {
    }

    public static function newId(): self
    {
        return new self(Uuid::uuid4());
    }

    public function get(): string
    {
        return $this->id->toString();
    }
}
