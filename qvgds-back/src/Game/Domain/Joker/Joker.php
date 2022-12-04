<?php

namespace QVGDS\Game\Domain\Joker;

interface Joker
{
    public function canBeUsed(): bool;

    public function type(): JokerType;

    public function status(): JokerStatus;
}
