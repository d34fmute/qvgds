<?php

namespace Game\Domain;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\ShitCoins;

class ShitCoinsTest extends TestCase
{

    #[Test]
    #[DataProvider("amount")]
    public function testAmount(ShitCoins $shitCoins, int $amount)
    {
        self::assertEquals($shitCoins->amount(), $amount);
    }

    public function amount(): array
    {
        return [
            "ShitCoins from level 0" => [ShitCoins::ZERO, 0],
            "ShitCoins from level 1" => [ShitCoins::ONE_HUNDRED, 100],
            "ShitCoins from level 2" => [ShitCoins::TWO_HUNDRED, 200],
            "ShitCoins from level 3" => [ShitCoins::THREE_HUNDRED, 300],
            "ShitCoins from level 4" => [ShitCoins::FIVE_HUNDRED, 500],
            "ShitCoins from level 5" => [ShitCoins::ONE_THOUSAND, 1000],
            "ShitCoins from level 6" => [ShitCoins::TWO_THOUSAND, 2000],
            "ShitCoins from level 7" => [ShitCoins::FOUR_THOUSAND, 4000],
            "ShitCoins from level 8" => [ShitCoins::EIGHT_THOUSAND, 8000],
            "ShitCoins from level 9" => [ShitCoins::TWELVE_THOUSAND, 12000],
            "ShitCoins from level 10" => [ShitCoins::TWENTY_FOUR_THOUSAND, 24000],
            "ShitCoins from level 11" => [ShitCoins::THIRTY_SIX_THOUSAND, 36000],
            "ShitCoins from level 12" => [ShitCoins::SEVENTY_TWO_THOUSAND, 72000],
            "ShitCoins from level 13" => [ShitCoins::ONE_HUNDRED_FIFTY_THOUSAND, 150000],
            "ShitCoins from level 14" => [ShitCoins::THREE_HUNDRED_THOUSAND, 300000],
            "ShitCoins from level 15" => [ShitCoins::ONE_MILLION, 1000000],
        ];
    }
}
