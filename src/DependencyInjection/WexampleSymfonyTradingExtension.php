<?php

namespace Wexample\SymfonyTrading\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Wexample\SymfonyHelpers\DependencyInjection\AbstractWexampleSymfonyExtension;
use Wexample\SymfonyTrading\Interface\MarketChartProviderInterface;

class WexampleSymfonyTradingExtension extends AbstractWexampleSymfonyExtension
{
    public function load(
        array $configs,
        ContainerBuilder $container
    ): void {
        $this->loadConfig(
            __DIR__,
            $container
        );

        // Any service of any bundle saying it provides a market chart is
        // found by the endpoints, with nothing to declare.
        $container->registerForAutoconfiguration(MarketChartProviderInterface::class)
            ->addTag(MarketChartProviderInterface::TAG);
    }
}
