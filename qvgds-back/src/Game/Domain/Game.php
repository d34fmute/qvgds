<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

use QVGDS\Game\Domain\Joker\Jokers;
use QVGDS\Game\Domain\Joker\JokerType;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\Question;
use QVGDS\Session\Domain\Session;
use QVGDS\Utils\Assert;

final class Game
{
    public function __construct(
        private readonly GameId  $id,
        private readonly string  $player,
        private readonly Jokers  $jokers,
        private readonly Session $session,
        private GameStatus       $status,
        private Level            $level = Level::ZERO
    )
    {
        Assert::notEmptyText("step", $player);
    }

    public static function start(GameId $id, string $player, Session $session): self
    {
        return new self($id, $player, new Jokers(), $session, GameStatus::IN_PROGRESS);
    }

    public function jokers(): Jokers
    {
        return $this->jokers;
    }

    public function guess(Answer $answer): self|Fail
    {
        $this->assertGameStatus();
        $isGuessed = $this->session->guess($this->level, $answer);
        if ($isGuessed) {
            $this->level = $this->level->next();
            return $this;
        }
        $this->status = GameStatus::LOST;

        return new Fail($this);
    }

    public function shitCoins(): ShitCoins
    {
        if ($this->status == GameStatus::LOST) {
            if ($this->isOverSecondThreshold()) {
                return ShitCoins::TWENTY_FOUR_THOUSAND;
            }
            if ($this->isOverFirstThreshold()) {
                return ShitCoins::ONE_THOUSAND;
            }
        }
        return ShitCoins::from($this->level->value);
    }

    /**
     * @return Answer[]
     */
    public function fiftyFifty(): array
    {
        $this->jokers->use(JokerType::FIFTY_FIFTY);

        return $this->session->fiftyFifty($this->level);
    }

    public function id(): GameId
    {
        return $this->id;
    }

    public function currentQuestion(): Question
    {
        return $this->session->question($this->level);
    }

    public function status(): GameStatus
    {
        return $this->status;
    }

    public function forgive(): void
    {
        $this->status = GameStatus::FORGIVEN;
    }

    private function assertGameStatus(): void
    {
        if ($this->status === GameStatus::LOST || $this->status === GameStatus::FORGIVEN) {
            throw new GameBlockedException($this->status->name);
        }
    }

    public function player(): string
    {
        return $this->player;
    }

    public function session(): Session
    {
        return $this->session;
    }

    public function step(): Level
    {
        return $this->level;
    }

    private function isOverSecondThreshold(): bool
    {
        return $this->level->value >= 10;
    }

    private function isOverFirstThreshold(): bool
    {
        return $this->level->value >= 5;
    }
}
