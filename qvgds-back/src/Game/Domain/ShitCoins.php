<?php

namespace QVGDS\Game\Domain;

enum ShitCoins: int
{
    case ZERO = 0;
    case ONE_HUNDRED = 1;
    case TWO_HUNDRED = 2;
    case THREE_HUNDRED = 3;
    case FIVE_HUNDRED = 4;
    case ONE_THOUSAND = 5;
    case TWO_THOUSAND = 6;
    case FOUR_THOUSAND = 7;
    case EIGHT_THOUSAND = 8;
    case TWELVE_THOUSAND = 9;
    case TWENTY_FOUR_THOUSAND = 10;
    case THIRTY_SIX_THOUSAND = 11;
    case SEVENTY_TWO_THOUSAND = 12;
    case ONE_HUNDRED_FIFTY_THOUSAND = 13;
    case THREE_HUNDRED_THOUSAND = 14;
    case ONE_MILLION = 15;

    public function amount(): int
    {
        return match ($this) {
            ShitCoins::ZERO => 0,
            ShitCoins::ONE_HUNDRED => 100,
            ShitCoins::TWO_HUNDRED => 200,
            ShitCoins::THREE_HUNDRED => 300,
            ShitCoins::FIVE_HUNDRED => 500,
            ShitCoins::ONE_THOUSAND => 1000,
            ShitCoins::TWO_THOUSAND => 2000,
            ShitCoins::FOUR_THOUSAND => 4000,
            ShitCoins::EIGHT_THOUSAND => 8000,
            ShitCoins::TWELVE_THOUSAND => 12000,
            ShitCoins::TWENTY_FOUR_THOUSAND => 24000,
            ShitCoins::THIRTY_SIX_THOUSAND => 36000,
            ShitCoins::SEVENTY_TWO_THOUSAND => 72000,
            ShitCoins::ONE_HUNDRED_FIFTY_THOUSAND => 150000,
            ShitCoins::THREE_HUNDRED_THOUSAND => 300000,
            ShitCoins::ONE_MILLION => 1000000,
        };
    }
}
