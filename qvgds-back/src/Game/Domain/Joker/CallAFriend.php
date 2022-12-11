<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

final class CallAFriend extends Joker
{
    public function type(): JokerType
    {
        return JokerType::CALL_A_FRIEND;
    }
}
