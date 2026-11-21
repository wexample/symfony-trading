<?php

namespace Wexample\SymfonyTrading\Tests\Unit\Helper;

use PHPUnit\Framework\TestCase;
use Wexample\SymfonyTrading\Helper\SharpeHelper;

class SharpeHelperTest extends TestCase
{
    public function testTheNormalLawReadsBothWays(): void
    {
        $this->assertEqualsWithDelta(0.5, SharpeHelper::normalCdf(0), 1e-7);
        $this->assertEqualsWithDelta(0.975, SharpeHelper::normalCdf(1.959964), 1e-6);
        $this->assertEqualsWithDelta(1.959964, SharpeHelper::normalQuantile(0.975), 1e-5);
        $this->assertEqualsWithDelta(-2.326348, SharpeHelper::normalQuantile(0.01), 1e-5);
    }

    public function testOneTrialIsBenchmarkedOnZero(): void
    {
        $this->assertSame(0.0, SharpeHelper::expectedMaximum(0.01, 1));
    }

    public function testTheBestOfManyTrialsIsExpectedHigher(): void
    {
        $few = SharpeHelper::expectedMaximum(0.0025, 10);
        $many = SharpeHelper::expectedMaximum(0.0025, 1000);

        $this->assertGreaterThan(0, $few);
        $this->assertGreaterThan($few, $many);
    }

    public function testTheProbabilisticSharpeOfTheLiterature(): void
    {
        // Bailey & López de Prado: SR 0.1 a bar over 250 normal returns,
        // benchmark 0: about 94 %.
        $this->assertEqualsWithDelta(0.9416, SharpeHelper::probabilistic(0.1, 0, 250, 0, 3), 1e-3);
    }

    public function testFatTailsAndNegativeSkewMakeItLessSure(): void
    {
        $normal = SharpeHelper::probabilistic(0.1, 0, 250, 0, 3);
        $fat = SharpeHelper::probabilistic(0.1, 0, 250, -1, 10);

        $this->assertLessThan($normal, $fat);
    }

    public function testTheSameSharpeIsLessSureAmongMoreTrials(): void
    {
        $alone = SharpeHelper::deflated(0.1, 1000, 0, 3, [0.1]);
        $amongMany = SharpeHelper::deflated(0.1, 1000, 0, 3, [0.1, 0.02, -0.03, 0.05, 0.0, 0.04, -0.01, 0.06]);

        $this->assertGreaterThan($amongMany, $alone);
    }

    public function testTooFewReturnsSayNothing(): void
    {
        $this->assertNull(SharpeHelper::probabilistic(0.1, 0, 1, 0, 3));
    }
}
