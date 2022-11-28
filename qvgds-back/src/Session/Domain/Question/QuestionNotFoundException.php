<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

use Exception;

final class QuestionNotFoundException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct("Question $message not found in this session");
    }

}