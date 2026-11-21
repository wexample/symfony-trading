<?php

namespace Wexample\SymfonyTrading\Helper;

/**
 * How sure a Sharpe ratio is, once it is known how many were tried to find it.
 *
 * Bailey & López de Prado (2014): the probabilistic Sharpe ratio is the
 * probability that the true Sharpe exceeds a benchmark, given how many returns
 * measured it and how far they stray from a normal law; the deflated Sharpe
 * ratio takes as benchmark the best Sharpe that chance alone would give among
 * that many trials. The Sharpe ratios here are per bar, not annualized.
 */
class SharpeHelper
{
    private const float EULER_MASCHERONI = 0.5772156649015329;

    /**
     * The probability that the true Sharpe of the returns exceeds the one
     * chance would give the best of `$sharpes` — the trials it was picked among,
     * itself included.
     *
     * @param list<float> $sharpes the per-bar Sharpe ratios of all the trials
     */
    public static function deflated(
        float $sharpe,
        int $count,
        float $skewness,
        float $kurtosis,
        array $sharpes,
    ): ?float {
        return self::probabilistic(
            $sharpe,
            self::expectedMaximum(self::variance($sharpes), count($sharpes)),
            $count,
            $skewness,
            $kurtosis,
        );
    }

    /**
     * The probability that the true Sharpe exceeds `$benchmark`, measured on
     * `$count` returns of that skewness and kurtosis (3 for a normal law).
     * Null when too few returns measured it to say.
     */
    public static function probabilistic(
        float $sharpe,
        float $benchmark,
        int $count,
        float $skewness,
        float $kurtosis,
    ): ?float {
        $spread = 1 - $skewness * $sharpe + ($kurtosis - 1) / 4 * $sharpe ** 2;

        if ($count < 2 || $spread <= 0) {
            return null;
        }

        return self::normalCdf(($sharpe - $benchmark) * sqrt($count - 1) / sqrt($spread));
    }

    /**
     * The best Sharpe that `$trials` trials of no skill would show, their
     * Sharpe ratios spreading with that variance; 0 for a single trial.
     */
    public static function expectedMaximum(
        float $variance,
        int $trials,
    ): float {
        if ($trials < 2 || $variance <= 0) {
            return 0.0;
        }

        return sqrt($variance) * (
            (1 - self::EULER_MASCHERONI) * self::normalQuantile(1 - 1 / $trials)
            + self::EULER_MASCHERONI * self::normalQuantile(1 - 1 / ($trials * M_E))
        );
    }

    /**
     * The standard normal law's cumulative probability (Abramowitz & Stegun
     * 7.1.26, within 1.5e-7).
     */
    public static function normalCdf(float $x): float
    {
        $z = abs($x) / M_SQRT2;
        $t = 1 / (1 + 0.3275911 * $z);
        $erf = 1 - (((((1.061405429 * $t - 1.453152027) * $t) + 1.421413741) * $t - 0.284496736) * $t + 0.254829592) * $t * exp(-$z * $z);

        return 0.5 * (1 + ($x >= 0 ? $erf : -$erf));
    }

    /**
     * The value under which the standard normal law falls with probability
     * `$p`, strictly between 0 and 1 (Acklam, within 1.2e-9).
     */
    public static function normalQuantile(float $p): float
    {
        if ($p <= 0 || $p >= 1) {
            throw new \InvalidArgumentException(sprintf('A probability strictly between 0 and 1, not %s.', $p));
        }

        $a = [-39.69683028665376, 220.9460984245205, -275.9285104469687, 138.3577518672690, -30.66479806614716, 2.506628277459239];
        $b = [-54.47609879822406, 161.5858368580409, -155.6989798598866, 66.80131188771972, -13.28068155288572];
        $c = [-0.007784894002430293, -0.3223964580411365, -2.400758277161838, -2.549732539343734, 4.374664141464968, 2.938163982698783];
        $d = [0.007784695709041462, 0.3224671290700398, 2.445134137142996, 3.754408661907416];
        $low = 0.02425;

        if ($p < $low) {
            $q = sqrt(-2 * log($p));

            return ((((($c[0] * $q + $c[1]) * $q + $c[2]) * $q + $c[3]) * $q + $c[4]) * $q + $c[5])
                / (((($d[0] * $q + $d[1]) * $q + $d[2]) * $q + $d[3]) * $q + 1);
        }

        if ($p > 1 - $low) {
            return -self::normalQuantile(1 - $p);
        }

        $q = $p - 0.5;
        $r = $q * $q;

        return ((((($a[0] * $r + $a[1]) * $r + $a[2]) * $r + $a[3]) * $r + $a[4]) * $r + $a[5]) * $q
            / ((((($b[0] * $r + $b[1]) * $r + $b[2]) * $r + $b[3]) * $r + $b[4]) * $r + 1);
    }

    /**
     * The sample variance of the values; 0 for fewer than two.
     *
     * @param list<float> $values
     */
    private static function variance(array $values): float
    {
        $count = count($values);

        if ($count < 2) {
            return 0.0;
        }

        $mean = array_sum($values) / $count;

        return array_sum(array_map(static fn (float $value): float => ($value - $mean) ** 2, $values)) / ($count - 1);
    }
}
