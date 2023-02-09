<?php
declare(strict_types=1);

namespace Game\Domain\Joker;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\Joker\CallAFriend;
use QVGDS\Game\Domain\Joker\FiftyFifty;
use QVGDS\Game\Domain\Joker\JokerNotAvailableException;
use QVGDS\Game\Domain\Joker\Jokers;
use QVGDS\Game\Domain\Joker\JokerStatus;
use QVGDS\Game\Domain\Joker\JokerType;

final class JokersTest extends TestCase
{
    #[Test]
    public function shouldNotUsedNotAvailableJoker(): void
    {
        $jokers = new Jokers(new CallAFriend(JokerStatus::ALREADY_USED));
        $this->expectException(JokerNotAvailableException::class);
        $this->expectExceptionMessage("Joker already used");

        $jokers->use(JokerType::CALL_A_FRIEND);
    }

    #[Test]
    public function shouldUseAJoker(): void
    {
        $jokers = new Jokers(new CallAFriend(JokerStatus::AVAILABLE));
        $jokers->use(JokerType::CALL_A_FRIEND);

        self::assertContainsEquals(new CallAFriend(JokerStatus::ALREADY_USED), $jokers->all());
    }

    #[Test]
    public function shouldCannotUseAbsentJoker(): void
    {
        $this->expectException(JokerNotAvailableException::class);
        $this->expectExceptionMessage("Joker not available");

        $jokers = new Jokers(new FiftyFifty(JokerStatus::AVAILABLE));
        $jokers->use(JokerType::CALL_A_FRIEND);
    }
}
