<?php

namespace Wexample\SymfonyTrading\Api\Normalizer\Entity\TradeMarker;

use ArrayObject;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;
use Wexample\SymfonyTrading\Api\Dto\PublicTradeMarkerDto;
use Wexample\SymfonyTrading\Entity\TradeMarker;
use Wexample\SymfonyTrading\Entity\Traits\Manipulator\TradeMarkerManipulatorTrait;

class DefaultTradeMarkerNormalizer extends AbstractEntityNormalizer
{
    use TradeMarkerManipulatorTrait;

    public function normalizeEntity(
        TradeMarker|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return PublicTradeMarkerDto::fromEntity($entity);
    }
}
