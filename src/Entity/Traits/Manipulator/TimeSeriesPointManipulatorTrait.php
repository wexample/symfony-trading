<?php

namespace Wexample\SymfonyTrading\Entity\Traits\Manipulator;

use Wexample\SymfonyHelpers\Entity\Traits\Manipulator\EntityManipulatorTrait;
use Wexample\SymfonyTrading\Entity\TimeSeriesPoint;

trait TimeSeriesPointManipulatorTrait
{
    use EntityManipulatorTrait;

    public static function getEntityClassName(): string
    {
        return TimeSeriesPoint::class;
    }
}
