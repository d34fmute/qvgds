<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain\Question;

final class BadAnswers
{
    /**
     * @var Answer[]
     */
    private readonly array $answers;

    public function __construct(private readonly Answer $answer1, private readonly Answer $answer2, private readonly Answer $answer3)
    {
        $this->answers = [$this->answer1, $this->answer2, $this->answer3];
    }

    /**
     * @return Answer[]
     */
    public function fiftyFifty(): array
    {
        $answers = $this->answers;
        $rand = array_rand($answers, 2);

        return [$answers[$rand[0]], $answers[$rand[1]]];
    }

    /**
     * @return Answer[]
     */
    public function get(): array
    {
        return $this->answers;
    }
}
