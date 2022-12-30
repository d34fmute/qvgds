<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

use OpenApi\Attributes\Schema;

#[Schema(title: "Joker type")]
enum JokerType
{
    case FIFTY_FIFTY;
    case CALL_A_FRIEND;
    case AUDIENCE_HELP;
}
