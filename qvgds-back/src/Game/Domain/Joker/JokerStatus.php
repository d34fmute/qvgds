<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

enum JokerStatus
{

    case AVAILABLE;
    case ALREADY_USED;

    public static function from(string $status): self
    {
        return match ($status) {
          JokerStatus::AVAILABLE->name => JokerStatus::AVAILABLE,
          JokerStatus::ALREADY_USED->name => JokerStatus::ALREADY_USED,
        };
    }
}
