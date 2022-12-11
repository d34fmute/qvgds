<?php
declare(strict_types=1);

namespace QVGDS\Utils;

final class NumberAsserter
{
    public function __construct(private readonly string $field, private readonly int $value)
    {
    }

    public function isEqualOrGreaterThan(int $min): void
    {
        if ($this->value < $min) {
            throw new InvalidNumberArgumentException($this->field, $min);
        }
    }

}
