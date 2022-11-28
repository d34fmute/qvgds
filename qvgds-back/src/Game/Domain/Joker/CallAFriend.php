<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

final class CallAFriend implements Joker
{
    public function __construct(private readonly JokerStatus $status)
    {
    }

    public function canBeUsed(): bool
    {
        return $this->status == JokerStatus::AVAILABLE;
    }

    public function type(): JokerType
    {
        return JokerType::CALL_A_FRIEND;
    }
}