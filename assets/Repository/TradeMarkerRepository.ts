import AbstractApiRepository from '@wexample/js-api-entity/Common/AbstractApiRepository';
import TradeMarker from '../Entity/TradeMarker.js';

export default class TradeMarkerRepository extends AbstractApiRepository<TradeMarker> {
  static getEntityType() {
    return TradeMarker;
  }
}
