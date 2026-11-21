<?php

namespace Wexample\SymfonyTrading\Enum;

/** Which way an order went: what a trade marker points at. */
enum TradeSide: string
{
    case BUY = 'buy';
    case SELL = 'sell';
}
