<?php

namespace Wexample\SymfonyTrading\Interface;

use Symfony\Component\HttpFoundation\Request;
use Wexample\SymfonyTrading\Entity\Candle;
use Wexample\SymfonyTrading\Entity\TimeSeriesPoint;
use Wexample\SymfonyTrading\Entity\TradeMarker;

/**
 * What an application implements to serve a market chart: a name, and for a
 * request its three layers — the candles of a market, the trades marked on
 * them, the series drawn along (an equity, an indicator). Autoconfigured:
 * implementing it is enough for `GET /_api/candle/list?chart=<name>`, and
 * its two siblings `trade-marker` and `time-series-point`, to answer.
 *
 * The request carries `scope` — what the chart is about, by its id: a
 * backtest, a market —, `timeframe` when the chart lets one choose the width
 * of its candles, and `from` / `to` when it asks for a period.
 * The provider checks the scope as it checks any access, and ignores what
 * it has no use for. `AbstractMarketChartProvider` answers no marker and no
 * series, for a chart of candles alone.
 */
interface MarketChartProviderInterface
{
    public const string TAG = 'wexample_symfony_trading.market_chart_provider';

    public static function getChartName(): string;

    /**
     * @return iterable<Candle> in time order
     */
    public function getCandles(Request $request): iterable;

    /**
     * @return iterable<TradeMarker>
     */
    public function getTradeMarkers(Request $request): iterable;

    /**
     * @return iterable<TimeSeriesPoint>
     */
    public function getTimeSeriesPoints(Request $request): iterable;
}
