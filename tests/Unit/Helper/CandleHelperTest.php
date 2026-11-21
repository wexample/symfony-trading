<?php

namespace Wexample\SymfonyTrading\Tests\Unit\Helper;

use PHPUnit\Framework\TestCase;
use Wexample\SymfonyTrading\Entity\Candle;
use Wexample\SymfonyTrading\Helper\CandleHelper;

class CandleHelperTest extends TestCase
{
    public function testFewEnoughCandlesAreKept(): void
    {
        $candles = [new Candle('btc', 0, 1, 2, 0.5, 1.5)];

        $this->assertSame($candles, CandleHelper::aggregate($candles, 10));
    }

    public function testConsecutiveCandlesMergeAsAWiderTimeframe(): void
    {
        $candles = [
            new Candle('btc', 0, 10, 12, 9, 11)->setVolume(1),
            new Candle('btc', 60, 11, 15, 10, 14)->setVolume(2),
            new Candle('btc', 120, 14, 14, 8, 9)->setVolume(3),
            new Candle('btc', 180, 9, 10, 7, 8),
        ];

        $merged = CandleHelper::aggregate($candles, 2);

        $this->assertCount(2, $merged);
        $this->assertSame([0, 10.0, 15.0, 9.0, 14.0, 3.0], [
            $merged[0]->getTime(), $merged[0]->getOpen(), $merged[0]->getHigh(), $merged[0]->getLow(), $merged[0]->getClose(), $merged[0]->getVolume(),
        ]);
        $this->assertSame([120, 14.0, 14.0, 7.0, 8.0, 3.0], [
            $merged[1]->getTime(), $merged[1]->getOpen(), $merged[1]->getHigh(), $merged[1]->getLow(), $merged[1]->getClose(), $merged[1]->getVolume(),
        ]);
    }

    public function testIdentityIsStable(): void
    {
        $this->assertTrue(new Candle('btc', 60, 1, 1, 1, 1)->getId()->equals(Candle::idFor('btc', 60)));
    }

    public function testAMomentFallsInTheCandleOpenedBeforeIt(): void
    {
        $times = [0, 240, 480];

        $this->assertSame(0, CandleHelper::candleTimeOf($times, -10));
        $this->assertSame(0, CandleHelper::candleTimeOf($times, 239));
        $this->assertSame(240, CandleHelper::candleTimeOf($times, 240));
        $this->assertSame(480, CandleHelper::candleTimeOf($times, 9999));
    }
}
