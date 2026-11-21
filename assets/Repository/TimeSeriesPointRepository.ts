import AbstractApiRepository from '@wexample/js-api-entity/Common/AbstractApiRepository';
import TimeSeriesPoint from '../Entity/TimeSeriesPoint.js';

export default class TimeSeriesPointRepository extends AbstractApiRepository<TimeSeriesPoint> {
  static getEntityType() {
    return TimeSeriesPoint;
  }
}
