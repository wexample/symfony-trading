<?php

namespace Wexample\SymfonyTrading\Entity;

use Symfony\Component\Uid\Uuid;
use Wexample\Pseudocode\Attribute\PseudocodeExport;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;

/**
 * One value of a series drawn along a market's candles: an equity, a moving
 * average. `pane` says where: 0 over the candles, on the price scale — an
 * indicator —, 1 and beyond in a pane of its own beneath them — an equity,
 * which is not a price.
 *
 * An entity without an ORM mapping, as `Candle`: computed when asked for.
 */
#[PseudocodeExport(inherited: true)]
class TimeSeriesPoint extends AbstractEntity
{
    /** Fixed namespace the identity is hashed under: the same point asked twice is the same entity. */
    public const ID_NAMESPACE = '9ec088b5-634f-4838-9930-62ff8dc8cdd8';

    /** The chart it belongs to, as its provider names it. */
    protected string $chart;

    /** The series it is a value of, by key. */
    protected string $series;

    /** The series as the legend writes it, already translated. */
    protected ?string $seriesLabel = null;

    /** When it stands, in seconds since the epoch, UTC. */
    protected int $time;

    /** Null where the series has no value: a gap. */
    protected ?float $value = null;

    /** 0 over the candles; 1 and beyond, a pane of its own beneath them. */
    protected int $pane = 0;

    /** A category of the design system palette: `mint`, `plum`…; the accent when null. */
    protected ?string $color = null;

    public function __construct(
        string $chart,
        string $series,
        int $time,
    ) {
        parent::__construct();

        $this->chart = $chart;
        $this->series = $series;
        $this->time = $time;

        $this->setId(self::idFor($chart, $series, $time));
    }

    public static function idFor(
        string $chart,
        string $series,
        int $time,
    ): Uuid {
        return Uuid::v5(Uuid::fromString(self::ID_NAMESPACE), $chart."\0".$series."\0".$time);
    }

    public function getChart(): string
    {
        return $this->chart;
    }

    public function getSeries(): string
    {
        return $this->series;
    }

    public function getSeriesLabel(): ?string
    {
        return $this->seriesLabel;
    }

    public function setSeriesLabel(?string $seriesLabel): self
    {
        $this->seriesLabel = $seriesLabel;

        return $this;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPane(): int
    {
        return $this->pane;
    }

    public function setPane(int $pane): self
    {
        $this->pane = $pane;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
