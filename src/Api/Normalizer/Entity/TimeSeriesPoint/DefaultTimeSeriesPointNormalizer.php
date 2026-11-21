<?php

namespace Wexample\SymfonyTrading\Api\Normalizer\Entity\TimeSeriesPoint;

use ArrayObject;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;
use Wexample\SymfonyTrading\Api\Dto\PublicTimeSeriesPointDto;
use Wexample\SymfonyTrading\Entity\TimeSeriesPoint;
use Wexample\SymfonyTrading\Entity\Traits\Manipulator\TimeSeriesPointManipulatorTrait;

class DefaultTimeSeriesPointNormalizer extends AbstractEntityNormalizer
{
    use TimeSeriesPointManipulatorTrait;

    public function normalizeEntity(
        TimeSeriesPoint|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return PublicTimeSeriesPointDto::fromEntity($entity);
    }
}
