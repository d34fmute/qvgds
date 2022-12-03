<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

final class AudienceHelp implements Joker
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
        return JokerType::AUDIENCE_HELP;
    }
}
