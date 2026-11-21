<?php

namespace Wexample\SymfonyTrading\Api\Normalizer\Entity\Candle;

use ArrayObject;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;
use Wexample\SymfonyTrading\Api\Dto\PublicCandleDto;
use Wexample\SymfonyTrading\Entity\Candle;
use Wexample\SymfonyTrading\Entity\Traits\Manipulator\CandleManipulatorTrait;

class DefaultCandleNormalizer extends AbstractEntityNormalizer
{
    use CandleManipulatorTrait;

    public function normalizeEntity(
        Candle|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return PublicCandleDto::fromEntity($entity);
    }
}
