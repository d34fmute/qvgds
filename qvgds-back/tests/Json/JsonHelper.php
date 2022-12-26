<?php
declare(strict_types=1);

namespace QVGDS\Tests\Json;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

final class JsonHelper
{
    public static function writeAsJson(object $from): string
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new GetSetMethodNormalizer(), new PropertyNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($from, "json");
    }
}
