<?php

declare(strict_types=1);

namespace App\Services;

class CurrencyFormatter
{
    /**
     * Convert satang (integer) to a formatted Baht string.
     * e.g. 50000 → "฿500.00"
     */
    public static function format(int $satang, string $symbol = '฿'): string
    {
        return $symbol.number_format($satang / 100, 2);
    }

    /**
     * Convert satang to Baht float.
     * e.g. 50000 → 500.0
     */
    public static function toBaht(int $satang): float
    {
        return $satang / 100;
    }

    /**
     * Convert Baht (float/string from form input) to satang integer.
     * e.g. 500 → 50000
     */
    public static function toSatang(float|string $baht): int
    {
        return (int) round((float) $baht * 100);
    }
}
