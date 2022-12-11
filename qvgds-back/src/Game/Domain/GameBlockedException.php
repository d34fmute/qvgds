<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

use QVGDS\Exception\QVGDSException;

final class GameBlockedException extends QVGDSException
{
    public function __construct(string $message)
    {
        parent::__construct(
            QVGDSException::builder()
                ->badRequest()
                ->withMessage("Game $message")
        );
    }

}
