<?php

namespace Wexample\SymfonyTrading\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyApi\Api\Attribute\ApiAccess;
use Wexample\SymfonyApi\Api\Attribute\QueryOption\StringQueryOption;
use Wexample\SymfonyApi\Api\Class\ApiResponse;
use Wexample\SymfonyHelpers\Controller\AbstractController;
use Wexample\SymfonyTrading\Api\Normalizer\Entity\Candle\DefaultCandleNormalizer;
use Wexample\SymfonyTrading\Service\MarketChartProviderRegistry;

/** The candles of a market chart, in time order. */
#[Route(path: '_api/candle/', name: 'api_candle_')]
#[ApiAccess(ApiAccess::CONTROLLER, "the chart's provider checks the scope it is asked about")]
class CandleController extends AbstractMarketChartController
{
    #[Route(path: 'list', name: self::ROUTE_LIST, methods: AbstractController::ROUTE_OPTIONS_METHOD_ONLY_GET, options: AbstractController::ROUTE_OPTIONS_ONLY_EXPOSE)]
    #[StringQueryOption(key: self::QUERY_OPTION_CHART, default: '')]
    #[StringQueryOption(key: self::QUERY_OPTION_SCOPE, default: '')]
    #[StringQueryOption(key: self::QUERY_OPTION_TIMEFRAME, default: '')]
    #[StringQueryOption(key: self::QUERY_OPTION_FROM, default: '')]
    #[StringQueryOption(key: self::QUERY_OPTION_TO, default: '')]
    public function list(
        Request $request,
        MarketChartProviderRegistry $registry,
        DefaultCandleNormalizer $normalizer,
    ): ApiResponse {
        return self::apiResponseCollection(
            $normalizer->normalizeCollection(self::listOf(self::provider($request, $registry)->getCandles($request)))
        );
    }
}
