<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

use Exception;

final class JokerNotAvailableException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

}
