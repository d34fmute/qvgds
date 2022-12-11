<?php
declare(strict_types=1);

namespace QVGDS\Utils;

use QVGDS\Exception\QVGDSException;

final class InvalidNumberArgumentException extends QVGDSException
{
    public function __construct(string $field, int $value)
    {
        parent::__construct(
            QVGDSException::builder()
                ->badRequest()
                ->withMessage("$field must be equal or greater than $value")
        );
    }

}
