import AbstractApiEntity from '@wexample/js-api-entity/Common/AbstractApiEntity';
import type { ApiEntitySchema } from '@wexample/js-api-entity/Common/AbstractApiEntity';
import schema from '../data/entity/time_series_point.json';

export default class TimeSeriesPoint extends AbstractApiEntity {
  static readonly entityName = 'timeSeriesPoint';

  // Typed as any schema, so that a subclass may answer its own.
  static retrieveEntitySchema(): ApiEntitySchema {
    return schema;
  }
}
