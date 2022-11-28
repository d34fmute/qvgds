<?php
declare(strict_types=1);

namespace Game\Domain\Joker;

use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\Joker\CallAFriend;
use QVGDS\Game\Domain\Joker\JokerNotAvailableException;
use QVGDS\Game\Domain\Joker\JokerStatus;
use QVGDS\Game\Domain\Joker\JokerType;
use QVGDS\Game\Domain\Joker\Jokers;

final class JokersTest extends TestCase
{
    /**
    * @test
    */
    public function shouldListAvailableJokers(): void
    {
        $jokers = new Jokers();

        self::assertEquals([JokerType::FIFTY_FIFTY, JokerType::CALL_A_FRIEND], $jokers->available());
    }
    
    /**
    * @test
    */
    public function shouldNotUsedNotAvailableJoker(): void
    {
        $jokers = new Jokers(new CallAFriend(JokerStatus::ALREADY_USED));
        $this->expectException(JokerNotAvailableException::class);
        $this->expectExceptionMessage("Joker already used");

        $jokers->use(JokerType::CALL_A_FRIEND);
    }

    /**
    * @test
    */
    public function shouldUseAJoker(): void
    {
        $jokers = new Jokers();
        $jokers->use(JokerType::CALL_A_FRIEND);

        $available = $jokers->available();
        self::assertEquals(JokerType::FIFTY_FIFTY, array_pop($available));
    }

}