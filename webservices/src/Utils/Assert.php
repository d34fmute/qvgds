<?php
declare(strict_types=1);

namespace QVGDS\Utils;

final class Assert
{

    public static function notEmptyText(string $field, string $value)
    {
        if ($value === "") {
            throw new MissingMandatoryValueException($field);
        }
    }

    public static function notEmptyArray(string $field, array $value)
    {
        if (empty($value)) {
            throw new MissingMandatoryValueException($field);
        }

    }

    public static function notNull(string $field, mixed $object)
    {
        if (is_null($object)) {
            throw new MissingMandatoryValueException($field);
        }
    }
}