<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

use QVGDS\Exception\QVGDSException;

final class GoodAnswerIsAlsoInBadAnswersException extends QVGDSException
{
    public function __construct()
    {
        parent::__construct(
            QVGDSException::builder()
                ->badRequest()
                ->withMessage("Good answers is also in bad answers")
        );
    }
}
