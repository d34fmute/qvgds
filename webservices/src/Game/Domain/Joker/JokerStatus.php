<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

enum JokerStatus
{

    case AVAILABLE;
    case ALREADY_USED;
}