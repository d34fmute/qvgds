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
        private int              $step = 1
    )
    {
        Assert::notEmptyText("step", $player);
        Assert::numberValue("step", $step)->isEqualOrGreaterThan(0);
    }

    public static function start(GameId $id, string $player, Session $session): self
    {
        return new self($id, $player, new Jokers(), $session, GameStatus::IN_PROGRESS);
    }

    public function jokers(): Jokers
    {
        return $this->jokers;
    }

    public function guess(Answer $answer): bool
    {
        $this->assertGameStatus();
        $isGuessed = $this->session->guess(1, $answer);
        if ($isGuessed) {
            $this->step += 1;
        } else {
            $this->status = GameStatus::LOST;
        }

        return $isGuessed;
    }

    public function shitCoins(): ShitCoins
    {
        return ShitCoins::fromLevel($this->step - 1, $this->status);
    }

    /**
     * @return Answer[]
     */
    public function fiftyFifty(): array
    {
        $this->jokers->use(JokerType::FIFTY_FIFTY);

        return $this->session->fiftyFifty($this->step);
    }

    public function id(): GameId
    {
        return $this->id;
    }

    public function currentQuestion(): Question
    {
        return $this->session->question($this->step);
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

    public function step(): int
    {
        return $this->step;
    }
}
