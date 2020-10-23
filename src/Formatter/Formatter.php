<?php

declare(strict_types=1);

namespace Madebybob\Number\Formatter;

use Locale;
use NumberFormatter;

class Formatter
{
    /**
     * Shorthand for formatting decimals.
     */
    public static function format(string $value, ?int $minFractionDigits = null, ?int $maxFractionDigits = null, ?string $locale = null): string
    {
        $options = [
            NumberFormatter::MIN_FRACTION_DIGITS => $minFractionDigits,
            NumberFormatter::MAX_FRACTION_DIGITS => $maxFractionDigits,
        ];

        return self::get(NumberFormatter::DECIMAL, $locale, $options)->format($value);
    }

    /**
     * Shorthand for formatting currency amounts.
     */
    public static function formatCurrency(string $value, string $isoCode, ?string $locale = null): string
    {
        return self::get(NumberFormatter::CURRENCY, $locale)->formatCurrency((float) $value, $isoCode);
    }

    /**
     * Provides an NumberFormatter instance of the PHP intl extension (and some syntax sugar).
     */
    public static function get(int $type, ?string $locale = null, array $options = []): NumberFormatter
    {
        if ($locale === null) {
            $locale = Locale::getDefault();
        }

        $formatter = new NumberFormatter($locale, $type);
        foreach ($options as $key => $value) {
            if ($value === null) {
                continue;
            }

            $formatter->setAttribute($key, $value);
        }

        return $formatter;
    }
}
