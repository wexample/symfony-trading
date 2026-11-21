## What this package holds

The data side of the market charts: a market chart is three lists of entities with no table — its `Candle`s, its `TradeMarker`s and its `TimeSeriesPoint`s —, each served by its own list endpoint. Drawing them is `symfony-trading-ds`.

As `ChartPoint` in `symfony-charts`, these entities are computed when asked for, from whatever the application stores (`symfony-api`, `usage/non-persisted-entities`), and travel the road every list travels: normalizer, dto, generated `.ts` entity and repository, which the market chart reads.

## The three layers

| Entity | Fields | Drawn as |
|---|---|---|
| `Candle` | `time` (seconds, UTC: when the bar opened), `open`, `high`, `low`, `close`, `volume` | the candles |
| `TradeMarker` | `time`, `side` (`buy`, `sell` — `TradeSide`), `price`, `pnl`, `label` | an arrow below a buy, above a sell; one closing a trade carries its `pnl`, which colours it |
| `TimeSeriesPoint` | `series`, `seriesLabel`, `time`, `value`, `pane`, `color` | a line per series: `pane` 0 over the candles (an indicator), 1 and beyond in a pane beneath (an equity) |

Each id is `Uuid::v5` of what the entity stands for — the chart and the time, plus the side and the price for a marker, plus the series for a point: the same entity asked twice is the same, reconciled in place by the front.

## Serving a market chart

Implement `MarketChartProviderInterface` in the application; it is autoconfigured, nothing to declare. `AbstractMarketChartProvider` answers no marker and no series, for a chart of candles alone:

```php
final readonly class TrialMarketChartProvider implements MarketChartProviderInterface
{
    public static function getChartName(): string
    {
        return 'trial-market';
    }

    public function getCandles(Request $request): iterable { /* … */ }

    public function getTradeMarkers(Request $request): iterable { /* … */ }

    public function getTimeSeriesPoints(Request $request): iterable { /* … */ }
}
```

`GET /_api/candle/list?chart=trial-market&scope=<id>`, `/_api/trade-marker/list` and `/_api/time-series-point/list` then answer with the standard entity collection. An unknown chart name is a 404. The query holds `chart`, `scope` — what the chart is about, by its id, which the provider checks as it checks any access —, `timeframe` — the width of the candles, for a chart offering several — and `from` / `to` (ISO dates, `to` excluded) for a provider that serves a period.

## Many bars

A chart draws a few thousand candles well; a span of 1 h bars over years is ten times that. `CandleHelper::aggregate($candles, $max)` merges consecutive candles into at most `$max`, as a wider timeframe would show them. Markers and series points must then stand on a candle drawn: `CandleHelper::candleTimeOf($times, $time)` gives the time of the candle a moment falls in.

## Front artifacts

`assets/Entity/*.ts`, `assets/Repository/*.ts` and `assets/Common/generated*.ts` are generated, never edited: after a change to an entity, regenerate them from an app as `symfony-api`'s `usage/entity-export-pipeline` says, pointing the paths at this package, and delete the foreign `.yml` the pseudocode command adds before the json export. An app adds `generatedRepositories` and `generatedEntitySchemas` to its api client.
