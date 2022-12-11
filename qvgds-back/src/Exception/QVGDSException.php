<?php
declare(strict_types=1);

namespace QVGDS\Exception;

use Exception;

abstract class QVGDSException extends Exception
{
    public function __construct(string $message = "", int $code = 400)
    {
        parent::__construct($message, $code);
    }

}
