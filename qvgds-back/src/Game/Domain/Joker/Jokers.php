<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

final class Jokers
{
    /**
     * @var Joker[]
     */
    private array $available;

    /**
     * @var Joker[]
     */
    private array $jokers;

    public function __construct(Joker ...$jokers)
    {
        $this->jokers = empty($jokers) ? [
            new FiftyFifty(JokerStatus::AVAILABLE),
            new CallAFriend(JokerStatus::AVAILABLE),
        ]: $jokers;

        $this->available = $this->computeAvailable();
    }

    public function available(): array
    {
        return $this->available;
    }

    public function use(JokerType $jokerType)
    {
        if (!in_array($jokerType, $this->available())) {
            throw new JokerNotAvailableException();
        }
        $this->available = array_filter($this->available, fn(JokerType $type): bool => $type != $jokerType);
    }

    private function computeAvailable(): array
    {
        return array_map(callback: fn(Joker $joker): JokerType => $joker->type(), array: array_filter($this->jokers, fn(Joker $joker): bool => $joker->canBeUsed()));
    }
}