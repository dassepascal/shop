<?php

if (!function_exists('price_without_vat')) {

    function price_without_vat(float $price_with_vat, int $vat_rate = 20): float 
    {
        return round($price_with_vat / (1.0 + (float)env('VAT_RATE', $vat_rate)), 2);
    }

    // Translation Lower case first
if (!function_exists('transL')) {
	function transL($key, $replace = [], $locale = null) {


		$key = trans($key, $replace, $locale);
		// return mb_strtolower($key, 'UTF-8');
		return mb_substr(mb_strtolower($key, 'UTF-8'), 0, 1) . mb_substr($key, 1);
	}
}
if (!function_exists('__L')) {
	function __L($key, $replace = [], $locale = null) {
		return transL($key, $replace, $locale);
	}
}

if (!function_exists(function: 'bigR')) {	
	function bigR(float|int $r, $dec = 2, $locale = null): bool|string
	{
		$locale ??= substr(Config::get('app.locale'), 0, 2);
		$fmt = new NumberFormatter(locale: $locale, style: NumberFormatter::DECIMAL);

		// echo "$locale<hr>";

		return $fmt->format(num: round($r, $dec));
	}
}

if (!function_exists('ftA')) {
	function ftA($amount, $locale = null): bool|string
	{
		$locale ??= config('app.locale');

		$lang = substr($locale, 0, 2);
		preg_match('/_([^_]*)$/', $locale, $matches);
		$currency  = $matches[1] ?? 'EUR';
		$formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
		$formatted = $formatter->formatCurrency($amount, $currency);
		return $formatted;
	}
}
}