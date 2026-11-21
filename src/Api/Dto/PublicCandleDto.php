<?php

namespace Wexample\SymfonyTrading\Api\Dto;

use Wexample\SymfonyApi\Api\Dto\AbstractEntityDto;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyTrading\Entity\Candle;

/** A candle as it goes on the wire: what the market chart draws of a bar. */
class PublicCandleDto extends AbstractEntityDto
{
    public string $chart;

    public int $time;

    public float $open;

    public float $high;

    public float $low;

    public float $close;

    public ?float $volume;

    /**
     * @param Candle $entity
     */
    public static function fromEntity(AbstractEntity $entity): self
    {
        $dto = parent::fromEntity($entity);

        $dto->chart = $entity->getChart();
        $dto->time = $entity->getTime();
        $dto->open = $entity->getOpen();
        $dto->high = $entity->getHigh();
        $dto->low = $entity->getLow();
        $dto->close = $entity->getClose();
        $dto->volume = $entity->getVolume();

        return $dto;
    }
}
