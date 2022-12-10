<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

final class ShitCoins
{

    private const SECOND_THRESHOLD = 10;
    private const FIRST_THRESHOLD = 5;

    private function __construct(private readonly int $amount)
    {
    }

    /**
     * @throws InvalidShitCoinsException
     */
    public static function of(int $amount): self
    {
        self::assertAmount($amount);

        return new self($amount);
    }

    private static function assertAmount(int $amount): void
    {
        if (!in_array($amount, self::pyramid())) {
            throw InvalidShitCoinsException::invalidAmount($amount);
        }
    }

    /**
     * @return array<int, int>
     */
    private static function pyramid(): array
    {
        return [
            1 => 100,
            2 => 200,
            3 => 300,
            4 => 500,
            self::FIRST_THRESHOLD => 1000,
            6 => 2000,
            7 => 4000,
            8 => 8000,
            9 => 12000,
            self::SECOND_THRESHOLD => 24000,
            11 => 36000,
            12 => 72000,
            13 => 150000,
            14 => 300000,
            15 => 1000000,
        ];
    }


    public static function fromLevel(int $level, GameStatus $status): self
    {
        self::assertLevel($level);
        if ($status === GameStatus::LOST) {
            return self::shitCoinsWithThreshold($level);
        }

        return self::converter($level);
    }

    private static function assertLevel(int $level): void
    {
        if (!array_key_exists($level, self::pyramid())) {
            throw InvalidShitCoinsException::invalidLevel($level);
        }
    }

    private static function converter(int $level): self
    {
        return new self(self::pyramid()[$level]);
    }

    private static function shitCoinsWithThreshold(int $level): ShitCoins
    {
        return match (true) {
            $level >= self::SECOND_THRESHOLD => self::converter(self::SECOND_THRESHOLD),
            $level >= self::FIRST_THRESHOLD => self::converter(self::FIRST_THRESHOLD),
            default => self::converter($level)
        };
    }

    public function amount(): int
    {
        return $this->amount;
    }
}
