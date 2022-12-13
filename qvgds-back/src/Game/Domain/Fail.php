<?php
declare(strict_types=1);

namespace QVGDS\Game\Domain;

final class Fail
{
    public function __construct(public readonly Game $game)
    {
    }

}
