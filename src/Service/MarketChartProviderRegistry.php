<?php

namespace Wexample\SymfonyTrading\Service;

use Psr\Container\ContainerInterface;
use Wexample\SymfonyTrading\Interface\MarketChartProviderInterface;

/**
 * Every market chart provider of the application, by the name of its chart.
 *
 * A locator rather than the providers themselves: a request reads one layer
 * of one chart, and only its provider is built for it.
 */
class MarketChartProviderRegistry
{
    /**
     * @param ContainerInterface $providers the tagged providers, indexed by
     *                                      `getChartName()`
     */
    public function __construct(
        private readonly ContainerInterface $providers,
    ) {
    }

    public function get(string $chart): ?MarketChartProviderInterface
    {
        return $this->providers->has($chart) ? $this->providers->get($chart) : null;
    }
}
