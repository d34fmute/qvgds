<?php

namespace Game\Domain;

use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\InvalidShitCoinsException;
use QVGDS\Game\Domain\ShitCoins;

class ShitCoinsTest extends TestCase
{

    /**
     * @test
     * @dataProvider pyramid
     */
    public function shouldBuildFromGrid(int $level, ShitCoins $shitCoins)
    {
        self::assertEquals($shitCoins, ShitCoins::fromLevel($level));
    }

    /**
    * @test
    */
    public function shouldNotBuildWithouWrongAmount(): void
    {
        $this->expectException(InvalidShitCoinsException::class);
        $this->expectExceptionMessage("Invalid amount: 300000000");
        ShitCoins::of(300000000);
    }

    /**
    * @test
    */
    public function shouldNotBuildWithUnknownLevel(): void
    {
        $this->expectException(InvalidShitCoinsException::class);
        $this->expectExceptionMessage("Invalid level: -2");
        ShitCoins::fromLevel(-2);

    }

    public function pyramid(): array
    {
        return [
          "ShitCoins from level 1" => [1, ShitCoins::of(100)],
          "ShitCoins from level 2" => [2, ShitCoins::of(200)],
          "ShitCoins from level 3" => [3, ShitCoins::of(300)],
          "ShitCoins from level 4" => [4, ShitCoins::of(500)],
          "ShitCoins from level 5" => [5, ShitCoins::of(1000)],
          "ShitCoins from level 6" => [6, ShitCoins::of(2000)],
          "ShitCoins from level 7" => [7, ShitCoins::of(4000)],
          "ShitCoins from level 8" => [8, ShitCoins::of(8000)],
          "ShitCoins from level 9" => [9, ShitCoins::of(12000)],
          "ShitCoins from level 10" => [10, ShitCoins::of(24000)],
          "ShitCoins from level 11" => [11, ShitCoins::of(36000)],
          "ShitCoins from level 12" => [12, ShitCoins::of(72000)],
          "ShitCoins from level 13" => [13, ShitCoins::of(150000)],
          "ShitCoins from level 14" => [14, ShitCoins::of(300000)],
          "ShitCoins from level 15" => [15, ShitCoins::of(1000000)],
        ];
    }
}
