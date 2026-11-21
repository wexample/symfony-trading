<?php

namespace Wexample\SymfonyTrading\Entity;

use Symfony\Component\Uid\Uuid;
use Wexample\Pseudocode\Attribute\PseudocodeExport;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;

/**
 * One bar of a market: its open, high, low and close over a timeframe.
 *
 * An entity without an ORM mapping — a candle is read when it is asked for,
 * from whatever the application stores its bars in — so that a market chart
 * travels the road every list of the stack travels: normalizer, dto,
 * generated `Candle.ts` and its repository, which the market chart reads.
 */
#[PseudocodeExport(inherited: true)]
class Candle extends AbstractEntity
{
    /** Fixed namespace the identity is hashed under: the same candle asked twice is the same entity. */
    public const ID_NAMESPACE = 'e42c01e4-e29a-444b-a087-eac3c79541b4';

    /** The chart it belongs to, as its provider names it. */
    protected string $chart;

    /** When the bar opened, in seconds since the epoch, UTC. */
    protected int $time;

    protected float $open;

    protected float $high;

    protected float $low;

    protected float $close;

    /** What was traded over the bar, in the base asset; null when unknown. */
    protected ?float $volume = null;

    public function __construct(
        string $chart,
        int $time,
        float $open,
        float $high,
        float $low,
        float $close,
    ) {
        parent::__construct();

        $this->chart = $chart;
        $this->time = $time;
        $this->open = $open;
        $this->high = $high;
        $this->low = $low;
        $this->close = $close;

        $this->setId(self::idFor($chart, $time));
    }

    public static function idFor(
        string $chart,
        int $time,
    ): Uuid {
        return Uuid::v5(Uuid::fromString(self::ID_NAMESPACE), $chart."\0".$time);
    }

    public function getChart(): string
    {
        return $this->chart;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(?float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }
}
