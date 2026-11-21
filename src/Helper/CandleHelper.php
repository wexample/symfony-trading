<?php

namespace Wexample\SymfonyTrading\Helper;

use Wexample\SymfonyTrading\Entity\Candle;

class CandleHelper
{
    /**
     * At most `$max` candles, consecutive ones merged into one when there are
     * more: the first's open, the highest high, the lowest low, the last's
     * close, the volumes summed — what a wider timeframe would have shown.
     * Each merged candle stands at the time of its first.
     *
     * @param list<Candle> $candles in time order
     *
     * @return list<Candle>
     */
    public static function aggregate(
        array $candles,
        int $max,
    ): array {
        $count = count($candles);

        if ($count <= $max) {
            return $candles;
        }

        $merged = [];

        foreach (array_chunk($candles, (int) ceil($count / $max)) as $group) {
            $first = $group[0];
            $volumes = array_filter(array_map(static fn (Candle $candle) => $candle->getVolume(), $group), static fn (?float $volume) => null !== $volume);

            $merged[] = new Candle(
                $first->getChart(),
                $first->getTime(),
                $first->getOpen(),
                max(array_map(static fn (Candle $candle) => $candle->getHigh(), $group)),
                min(array_map(static fn (Candle $candle) => $candle->getLow(), $group)),
                $group[count($group) - 1]->getClose(),
            )->setVolume($volumes ? array_sum($volumes) : null);
        }

        return $merged;
    }

    /**
     * The time of the candle a moment falls in: the last candle opened at or
     * before it — the first, for a moment before them all. A marker or a
     * series point placed there stands on a candle drawn, merged or not.
     *
     * @param list<int> $times the candles' times, ascending
     */
    public static function candleTimeOf(
        array $times,
        int $time,
    ): int {
        $low = 0;
        $high = count($times) - 1;
        $found = $times[0];

        while ($low <= $high) {
            $middle = intdiv($low + $high, 2);

            if ($times[$middle] <= $time) {
                $found = $times[$middle];
                $low = $middle + 1;
            } else {
                $high = $middle - 1;
            }
        }

        return $found;
    }
}
