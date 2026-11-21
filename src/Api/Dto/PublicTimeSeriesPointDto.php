<?php

namespace Wexample\SymfonyTrading\Api\Dto;

use Wexample\SymfonyApi\Api\Dto\AbstractEntityDto;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyTrading\Entity\TimeSeriesPoint;

/** A point of a series as it goes on the wire: what the market chart draws along the candles. */
class PublicTimeSeriesPointDto extends AbstractEntityDto
{
    public string $chart;

    public string $series;

    public ?string $seriesLabel;

    public int $time;

    public ?float $value;

    public int $pane;

    public ?string $color;

    /**
     * @param TimeSeriesPoint $entity
     */
    public static function fromEntity(AbstractEntity $entity): self
    {
        $dto = parent::fromEntity($entity);

        $dto->chart = $entity->getChart();
        $dto->series = $entity->getSeries();
        $dto->seriesLabel = $entity->getSeriesLabel();
        $dto->time = $entity->getTime();
        $dto->value = $entity->getValue();
        $dto->pane = $entity->getPane();
        $dto->color = $entity->getColor();

        return $dto;
    }
}
