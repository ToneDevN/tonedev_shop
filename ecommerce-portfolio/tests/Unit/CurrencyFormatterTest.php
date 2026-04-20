<?php

declare(strict_types=1);

use App\Services\CurrencyFormatter;

it('formats satang to Thai Baht display string', function (): void {
    expect(CurrencyFormatter::format(50000))->toBe('฿500.00')
        ->and(CurrencyFormatter::format(100))->toBe('฿1.00')
        ->and(CurrencyFormatter::format(0))->toBe('฿0.00');
});

it('converts Baht to satang', function (): void {
    expect(CurrencyFormatter::toSatang(500))->toBe(50000)
        ->and(CurrencyFormatter::toSatang(1.50))->toBe(150)
        ->and(CurrencyFormatter::toSatang('299.99'))->toBe(29999);
});

it('converts satang to Baht float', function (): void {
    expect(CurrencyFormatter::toBaht(50000))->toBe(500.0)
        ->and(CurrencyFormatter::toBaht(150))->toBe(1.5);
});
