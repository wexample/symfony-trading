<?php

namespace Wexample\SymfonyTrading\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyApi\Api\Attribute\ApiAccess;
use Wexample\SymfonyApi\Api\Attribute\QueryOption\StringQueryOption;
use Wexample\SymfonyApi\Api\Class\ApiResponse;
use Wexample\SymfonyHelpers\Controller\AbstractController;
use Wexample\SymfonyTrading\Api\Normalizer\Entity\TimeSeriesPoint\DefaultTimeSeriesPointNormalizer;
use Wexample\SymfonyTrading\Service\MarketChartProviderRegistry;

/** The series drawn along a market chart. */
#[Route(path: '_api/time-series-point/', name: 'api_time_series_point_')]
#[ApiAccess(ApiAccess::CONTROLLER, "the chart's provider checks the scope it is asked about")]
class TimeSeriesPointController extends AbstractMarketChartController
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
        DefaultTimeSeriesPointNormalizer $normalizer,
    ): ApiResponse {
        return self::apiResponseCollection(
            $normalizer->normalizeCollection(self::listOf(self::provider($request, $registry)->getTimeSeriesPoints($request)))
        );
    }
}
