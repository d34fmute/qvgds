<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

enum GameStatus
{
    case LOST;
    case FORGIVEN;
    case IN_PROGRESS;
}
