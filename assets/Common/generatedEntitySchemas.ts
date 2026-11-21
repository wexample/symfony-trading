import candle from '../data/entity/candle.json';
import timeSeriesPoint from '../data/entity/time_series_point.json';
import tradeMarker from '../data/entity/trade_marker.json';

type EntitySchema = { name: string };

export default function getGeneratedEntitySchemas(): Record<string, EntitySchema> {
  return {
    [candle.name]: candle,
    [timeSeriesPoint.name]: timeSeriesPoint,
    [tradeMarker.name]: tradeMarker,
  };
}
