<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

final class BadAnswers
{
    public function __construct(private readonly Answer $answer1, private readonly Answer $answer2, private readonly Answer $answer3)
    {
    }

    /**
     * @return Answer[]
     */
    public function fiftyFifty(): array
    {
        $answers = [$this->answer1, $this->answer2, $this->answer3];
        $rand = array_rand($answers, 2);

        return [$answers[$rand[0]], $answers[$rand[1]]];
    }
}