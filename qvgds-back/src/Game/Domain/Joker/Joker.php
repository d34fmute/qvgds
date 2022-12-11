<?php

namespace QVGDS\Game\Domain\Joker;

abstract class Joker
{
    final public function __construct(protected readonly JokerStatus $status)
    {
    }

    public function canBeUsed(): bool
    {
        return $this->status === JokerStatus::AVAILABLE;
    }

    abstract public function type(): JokerType;

    public function status(): JokerStatus
    {
        return $this->status;
    }

    public function use(): Joker
    {
        if (!$this->canBeUsed()) {
            throw new JokerNotAvailableException("Joker already used");
        }
        return new static(JokerStatus::ALREADY_USED);
    }
}
