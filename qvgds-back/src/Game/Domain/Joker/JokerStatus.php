<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

enum JokerStatus: string
{

    case AVAILABLE = "AVAILABLE";
    case ALREADY_USED = "ALREADY_USED";
}
