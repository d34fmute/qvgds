<?php
declare(strict_types=1);

namespace QVGDS\Utils;

use QVGDS\Exception\QVGDSException;

final class MissingMandatoryValueException extends QVGDSException
{
    public function __construct(string $field)
    {
        parent::__construct(
            QVGDSException::builder()
                ->badRequest()
                ->withMessage("$field cannot be empty")
        );
    }
}
