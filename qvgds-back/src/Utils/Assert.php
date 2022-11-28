<?php
declare(strict_types=1);

namespace QVGDS\Utils;

final class Assert
{
    public static function notEmptyText(string $field, string $value): void
    {
        if ($value === "") {
            throw new MissingMandatoryValueException($field);
        }
    }
}
