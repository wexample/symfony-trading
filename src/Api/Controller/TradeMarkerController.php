<?php

namespace Wexample\SymfonyTrading\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyApi\Api\Attribute\ApiAccess;
use Wexample\SymfonyApi\Api\Attribute\QueryOption\StringQueryOption;
use Wexample\SymfonyApi\Api\Class\ApiResponse;
use Wexample\SymfonyHelpers\Controller\AbstractController;
use Wexample\SymfonyTrading\Api\Normalizer\Entity\TradeMarker\DefaultTradeMarkerNormalizer;
use Wexample\SymfonyTrading\Service\MarketChartProviderRegistry;

/** The trades marked on a market chart. */
#[Route(path: '_api/trade-marker/', name: 'api_trade_marker_')]
#[ApiAccess(ApiAccess::CONTROLLER, "the chart's provider checks the scope it is asked about")]
class TradeMarkerController extends AbstractMarketChartController
{
    #[Route(path: 'list', name: self::ROUTE_LIST, methods: AbstractController::ROUTE_OPTIONS_METHOD_ONLY_GET, options: AbstractController::ROUTE_OPTIONS_ONLY_EXPOSE)]
    #[StringQueryOption(key: self::QUERY_OPTION_CHART, default: '')]
    #[StringQueryOption(key: self::QUERY_OPTION_SCOPE, default: '')]
    #[StringQueryOption(key: self::QUERY_OPTION_FROM, default: '')]
    #[StringQueryOption(key: self::QUERY_OPTION_TO, default: '')]
    public function list(
        Request $request,
        MarketChartProviderRegistry $registry,
        DefaultTradeMarkerNormalizer $normalizer,
    ): ApiResponse {
        return self::apiResponseCollection(
            $normalizer->normalizeCollection(self::listOf(self::provider($request, $registry)->getTradeMarkers($request)))
        );
    }
}
