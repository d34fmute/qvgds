<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

use OpenApi\Attributes\Schema;

#[Schema(title: "Joker status")]
enum JokerStatus
{

    case AVAILABLE;
    case ALREADY_USED;
}
