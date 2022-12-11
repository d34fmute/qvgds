<?php
declare(strict_types=1);

namespace QVGDS\Exception;

use Exception;

class QVGDSException extends Exception
{
    public function __construct(QVGDSExceptionBuilder $builder)
    {
        parent::__construct($builder->message, $builder->code);
    }

    public static function builder(): QVGDSExceptionBuilder
    {
        return new QVGDSExceptionBuilder();
    }
}
