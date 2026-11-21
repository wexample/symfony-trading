import AbstractApiRepository from '@wexample/js-api-entity/Common/AbstractApiRepository';
import Candle from '../Entity/Candle.js';

export default class CandleRepository extends AbstractApiRepository<Candle> {
  static getEntityType() {
    return Candle;
  }
}
