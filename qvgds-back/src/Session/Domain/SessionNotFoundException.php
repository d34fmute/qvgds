<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

use QVGDS\Exception\QVGDSException;

final class SessionNotFoundException extends QVGDSException
{
    public function __construct()
    {
        parent::__construct(
            QVGDSException::builder()
                ->notFound()
                ->withMessage("Session not found")
        );
    }
}
