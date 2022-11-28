<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

final class GoodAnswer
{
    public function __construct(public readonly Answer $text)
    {
    }
}
