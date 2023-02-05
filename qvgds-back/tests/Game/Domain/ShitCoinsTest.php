<?php

namespace Game\Domain;

use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\ShitCoins;

class ShitCoinsTest extends TestCase
{

    /**
     * @test
     * @dataProvider amount
     */
    public function testAmount(int $shitCoins, int $amount)
    {
        self::assertEquals(ShitCoins::from($shitCoins)->amount(), $amount);
    }

    public function amount(): array
    {
        return [
            "ShitCoins from level 0" => [0, 0],
            "ShitCoins from level 1" => [1, 100],
            "ShitCoins from level 2" => [2, 200],
            "ShitCoins from level 3" => [3, 300],
            "ShitCoins from level 4" => [4, 500],
            "ShitCoins from level 5" => [5, 1000],
            "ShitCoins from level 6" => [6, 2000],
            "ShitCoins from level 7" => [7, 4000],
            "ShitCoins from level 8" => [8, 8000],
            "ShitCoins from level 9" => [9, 12000],
            "ShitCoins from level 10" => [10, 24000],
            "ShitCoins from level 11" => [11, 36000],
            "ShitCoins from level 12" => [12, 72000],
            "ShitCoins from level 13" => [13, 150000],
            "ShitCoins from level 14" => [14, 300000],
            "ShitCoins from level 15" => [15, 1000000],
        ];
    }
}
