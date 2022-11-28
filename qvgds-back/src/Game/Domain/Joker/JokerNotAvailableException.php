<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

use Exception;

final class JokerNotAvailableException extends Exception
{
    public function __construct()
    {
        parent::__construct("Joker already used");
    }

}