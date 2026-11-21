<?php

namespace Wexample\SymfonyTrading\Entity;

use Symfony\Component\Uid\Uuid;
use Wexample\Pseudocode\Attribute\PseudocodeExport;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyTrading\Enum\TradeSide;

/**
 * An order filled, marked on the candle it filled on: a buy below it, a sell
 * above it. The one closing a trade says what the trade made (`pnl`), which
 * colours it — a gain or a loss.
 *
 * An entity without an ORM mapping, as `Candle`: computed when asked for.
 */
#[PseudocodeExport(inherited: true)]
class TradeMarker extends AbstractEntity
{
    /** Fixed namespace the identity is hashed under: the same marker asked twice is the same entity. */
    public const ID_NAMESPACE = '282633b1-70e3-4a8c-be13-8991f1c9f209';

    /** The chart it belongs to, as its provider names it. */
    protected string $chart;

    /** When the order filled, in seconds since the epoch, UTC. */
    protected int $time;

    /** `buy` or `sell` (TradeSide). */
    protected string $side;

    /** The price it filled at. */
    protected float $price;

    /** Closing a trade: what the trade made, fees included; null on an opening order. */
    protected ?float $pnl = null;

    /** Written beside the marker, already worded; none when null. */
    protected ?string $label = null;

    public function __construct(
        string $chart,
        int $time,
        TradeSide $side,
        float $price,
    ) {
        parent::__construct();

        $this->chart = $chart;
        $this->time = $time;
        $this->side = $side->value;
        $this->price = $price;

        $this->setId(self::idFor($chart, $time, $side, $price));
    }

    public static function idFor(
        string $chart,
        int $time,
        TradeSide $side,
        float $price,
    ): Uuid {
        return Uuid::v5(Uuid::fromString(self::ID_NAMESPACE), $chart."\0".$time."\0".$side->value."\0".$price);
    }

    public function getChart(): string
    {
        return $this->chart;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPnl(): ?float
    {
        return $this->pnl;
    }

    public function setPnl(?float $pnl): self
    {
        $this->pnl = $pnl;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
