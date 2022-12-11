<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

final class FiftyFifty extends Joker
{
    public function type(): JokerType
    {
        return JokerType::FIFTY_FIFTY;
    }
}
