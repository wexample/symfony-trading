import AbstractApiEntity from '@wexample/js-api-entity/Common/AbstractApiEntity';
import type { ApiEntitySchema } from '@wexample/js-api-entity/Common/AbstractApiEntity';
import schema from '../data/entity/trade_marker.json';

export default class TradeMarker extends AbstractApiEntity {
  static readonly entityName = 'tradeMarker';

  // Typed as any schema, so that a subclass may answer its own.
  static retrieveEntitySchema(): ApiEntitySchema {
    return schema;
  }
}
