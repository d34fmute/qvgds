<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

final class FiftyFifty implements Joker
{
    public function __construct(private JokerStatus $status)
    {
    }

    public function type(): JokerType
    {
        return JokerType::FIFTY_FIFTY;
    }

    public function canBeUsed(): bool
    {
        return $this->status === JokerStatus::AVAILABLE;
    }

    public function status(): JokerStatus
    {
        return $this->status;
    }
}
