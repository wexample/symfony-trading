<?php

namespace Wexample\SymfonyTrading\Class;

use Symfony\Component\HttpFoundation\Request;
use Wexample\SymfonyTrading\Interface\MarketChartProviderInterface;

/** A market chart of candles alone: no trade marked, no series drawn along. */
abstract class AbstractMarketChartProvider implements MarketChartProviderInterface
{
    public function getTradeMarkers(Request $request): iterable
    {
        return [];
    }

    public function getTimeSeriesPoints(Request $request): iterable
    {
        return [];
    }
}
