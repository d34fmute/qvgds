<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

use QVGDS\Exception\QVGDSException;

final class JokerNotAvailableException extends QVGDSException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

}
