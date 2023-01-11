<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

use OpenApi\Attributes\Schema;

#[Schema(title: "Game status")]
enum GameStatus
{
    case LOST;
    case FORGIVEN;
    case IN_PROGRESS;
}
