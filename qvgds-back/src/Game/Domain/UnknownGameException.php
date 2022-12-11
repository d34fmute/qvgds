<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

use QVGDS\Exception\QVGDSException;

final class UnknownGameException extends QVGDSException
{
    public function __construct()
    {
        parent::__construct(code: 404);
    }

}
