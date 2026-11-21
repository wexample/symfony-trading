<?php

namespace Wexample\SymfonyTrading\Api\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Wexample\SymfonyApi\Api\Controller\AbstractApiController;
use Wexample\SymfonyTrading\Interface\MarketChartProviderInterface;
use Wexample\SymfonyTrading\Service\MarketChartProviderRegistry;

/**
 * A layer of a market chart — its candles, its trade markers, its series —,
 * as the `list` of the entity it is made of, which the generated repository
 * calls without being told where it is. Which chart is the `chart` option;
 * `scope` what it is about, by its id; `from` and `to` (ISO dates, `to`
 * excluded) a period. The provider reads them from the request, checks the
 * scope as it checks any access, and ignores what it has no use for.
 */
abstract class AbstractMarketChartController extends AbstractApiController
{
    final public const string ROUTE_LIST = 'list';

    final public const string QUERY_OPTION_CHART = 'chart';

    final public const string QUERY_OPTION_SCOPE = 'scope';

    final public const string QUERY_OPTION_FROM = 'from';

    final public const string QUERY_OPTION_TO = 'to';

    protected static function provider(
        Request $request,
        MarketChartProviderRegistry $registry,
    ): MarketChartProviderInterface {
        $chart = (string) self::getQueryOptionValue($request, self::QUERY_OPTION_CHART, '');

        return $registry->get($chart)
            ?? throw new NotFoundHttpException(sprintf('No market chart is named "%s".', $chart));
    }

    /**
     * @template T
     *
     * @param iterable<T> $items
     *
     * @return list<T>
     */
    protected static function listOf(iterable $items): array
    {
        return is_array($items) ? array_values($items) : iterator_to_array($items, false);
    }
}
