<?php

namespace Wexample\SymfonyTrading\Api\Dto;

use Wexample\SymfonyApi\Api\Dto\AbstractEntityDto;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyTrading\Entity\TradeMarker;

/** A trade marker as it goes on the wire: what the market chart marks on a candle. */
class PublicTradeMarkerDto extends AbstractEntityDto
{
    public string $chart;

    public int $time;

    public string $side;

    public float $price;

    public ?float $pnl;

    public ?string $label;

    /**
     * @param TradeMarker $entity
     */
    public static function fromEntity(AbstractEntity $entity): self
    {
        $dto = parent::fromEntity($entity);

        $dto->chart = $entity->getChart();
        $dto->time = $entity->getTime();
        $dto->side = $entity->getSide();
        $dto->price = $entity->getPrice();
        $dto->pnl = $entity->getPnl();
        $dto->label = $entity->getLabel();

        return $dto;
    }
}
