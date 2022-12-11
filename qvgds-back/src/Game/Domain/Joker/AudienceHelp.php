<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

final class AudienceHelp extends Joker
{
    public function type(): JokerType
    {
        return JokerType::AUDIENCE_HELP;
    }
}
