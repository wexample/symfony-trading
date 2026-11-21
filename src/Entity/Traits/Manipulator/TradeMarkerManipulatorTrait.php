<?php

namespace Wexample\SymfonyTrading\Entity\Traits\Manipulator;

use Wexample\SymfonyHelpers\Entity\Traits\Manipulator\EntityManipulatorTrait;
use Wexample\SymfonyTrading\Entity\TradeMarker;

trait TradeMarkerManipulatorTrait
{
    use EntityManipulatorTrait;

    public static function getEntityClassName(): string
    {
        return TradeMarker::class;
    }
}
