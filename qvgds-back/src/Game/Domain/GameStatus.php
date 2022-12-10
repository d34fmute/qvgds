<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

enum GameStatus: string
{
    case LOST = "LOST";
    case FORGIVEN = "FORGIVEN";
    case IN_PROGRESS = "IN_PROGRESS";
}
