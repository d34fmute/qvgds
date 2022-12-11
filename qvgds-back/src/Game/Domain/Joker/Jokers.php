<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain\Joker;

final class Jokers
{
    /**
     * @var Joker[]
     */
    private array $jokers;

    public function __construct(Joker ...$jokers)
    {
        $this->buildJokers($jokers);
    }

    /**
     * @return JokerType[]
     */
    public function availables(): array
    {
        return $this->computeAvailable();
    }

    public function use(JokerType $jokerType): void
    {
        $this->jokers[$jokerType->name] = $this->jokers[$jokerType->name]->use();
    }

    /**
     * @return JokerType[]
     */
    private function computeAvailable(): array
    {
        $jokers = array_values($this->jokers);
        $filter = array_filter($jokers, fn(Joker $joker): bool => $joker->canBeUsed());
        return array_map(
            callback: fn(Joker $joker): JokerType => $joker->type(),
            array: $filter
        );
    }

    /**
     * @return Joker[]
     */
    public function all(): array
    {
        return $this->jokers;
    }

    /**
     * @param Joker[] $jokers
     */
    private function buildJokers(array $jokers): void
    {
        if (empty($jokers)) {
            $this->jokers = [
                JokerType::FIFTY_FIFTY->value => new FiftyFifty(JokerStatus::AVAILABLE),
                JokerType::CALL_A_FRIEND->value => new CallAFriend(JokerStatus::AVAILABLE),
                JokerType::AUDIENCE_HELP->value => new AudienceHelp(JokerStatus::AVAILABLE)
            ];
        } else {
            array_walk($jokers, fn(Joker $joker) => $this->jokers[$joker->type()->value] = $joker);
        }
    }
}
