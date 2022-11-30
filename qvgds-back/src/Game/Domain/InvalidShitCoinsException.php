<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

use Exception;

final class InvalidShitCoinsException extends Exception
{
    public static function invalidAmount(int $amount): self
    {
        return new self("Invalid amount: $amount");
    }

    public static function invalidLevel(int $level): self
    {
        return new self("Invalid level: $level");
    }
}
