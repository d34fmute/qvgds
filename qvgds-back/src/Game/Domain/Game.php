<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

use QVGDS\Game\Domain\Joker\Jokers;
use QVGDS\Game\Domain\Joker\JokerType;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\Question\QuestionId;
use QVGDS\Session\Domain\Session;

final class Game
{

    public function __construct(private readonly GameId $id, private readonly Jokers $jokers, private readonly Session $session, private int $score = 0)
    {
    }

    public static function start(GameId $id, Session $session): self
    {
        return new self($id, new Jokers(), $session);
    }

    /**
     * @return JokerType[]
     */
    public function jokers(): array
    {
        return $this->jokers->available();
    }

    public function guess(QuestionId $questionId, Answer $answer): bool
    {
        $isGuessed = $this->session->guess($questionId, $answer);
        if ($isGuessed) {
            $this->score += 1;
        }
        return $isGuessed;
    }

    public function shitCoins(): ShitCoins
    {
        return ShitCoins::fromLevel($this->score);
    }

    /**
     * @return Answer[]
     */
    public function fiftyFifty(QuestionId $id): array
    {
        $this->jokers->use(JokerType::FIFTY_FIFTY);

        return $this->session->fiftyFifty($id);
    }
}
