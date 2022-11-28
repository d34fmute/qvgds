<?php
declare(strict_types=1);

namespace QVGDS\Session\Domain;

final class QuestionId
{
    public function __construct(public readonly int $id)
    {
    }
}