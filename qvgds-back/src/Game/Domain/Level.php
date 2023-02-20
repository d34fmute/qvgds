<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

enum Level: int
{
    case ZERO = 0;
    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
    case FOUR = 4;
    case FIVE = 5;
    case SIX = 6;
    case SEVEN = 7;
    case EIGHT = 8;
    case NINE = 9;
    case TEN = 10;
    case ELEVEN = 11;
    case TWELVE = 12;
    case THIRTEEN = 13;
    case FOURTEEN = 14;
    case FIFTEEN = 15;

    public function next(): self
    {
        return match ($this) {
            Level::ZERO => Level::ONE,
            Level::ONE => Level::TWO,
            Level::TWO => Level::THREE,
            Level::THREE => Level::FOUR,
            Level::FOUR => Level::FIVE,
            Level::FIVE => Level::SIX,
            Level::SIX => Level::SEVEN,
            Level::SEVEN => Level::EIGHT,
            Level::EIGHT => Level::NINE,
            Level::NINE => Level::TEN,
            Level::TEN => Level::ELEVEN,
            Level::ELEVEN => Level::TWELVE,
            Level::TWELVE => Level::THIRTEEN,
            Level::THIRTEEN => Level::FOURTEEN,
            Level::FOURTEEN => Level::FIFTEEN,
            Level::FIFTEEN => Level::FIFTEEN
        };
    }
}
