<?php
declare(strict_types=1);

namespace QVGDS\Utils;

final class NumberAsserter
{
    public function __construct(private readonly string $field, private readonly int $value)
    {
    }

    public function isEqualOrGreaterThan(int $int): void
    {
        if ($int >= $this->value){
            throw new InvalidNumberArgumentException("$this->field must be equal or greater than 0");
        }
    }

}
