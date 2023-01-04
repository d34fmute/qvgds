<?php
declare(strict_types=1);

namespace QVGDS\Tests\Json;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonHelper
{
    public static function writeAsJson(object $from): string
    {
        return self::serializer()->serialize($from, "json");
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    public static function readFromJson(string $payload, string $className): object
    {
        return self::serializer()->deserialize($payload, $className, "json");
    }

    private static function serializer(): SerializerInterface
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new GetSetMethodNormalizer(), new PropertyNormalizer()];

        return new Serializer($normalizers, $encoders);
    }
}
