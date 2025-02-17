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

if (!function_exists('getBestPrice')) {
	function getBestPrice($product)
	{
		$promoGlobal = \App\Models\Setting::where('key', 'promotion')->first();

		// Vérifie si la promotion globale est valide
		$globalPromoValid = $promoGlobal && $promoGlobal->value && now()->between($promoGlobal->date1, $promoGlobal->date2);

		// Vérifie si la promotion spécifique du produit est valide
		$productPromoValid = $product->promotion_price && now()->between($product->promotion_start_date, $product->promotion_end_date);

		// Initialise le meilleur prix avec le prix normal du produit
		$bestPrice = $product->price;

		// Si la promotion spécifique du produit est valide, utilise ce prix
		if ($productPromoValid) {
			$bestPrice = $product->promotion_price;
		}

		// Si la promotion globale est valide, calcule le prix avec la réduction globale
		if ($globalPromoValid) {
			$globalPromoPrice = $product->price * (1 - $promoGlobal->value / 100);
			if ($globalPromoPrice < $bestPrice) {
				$bestPrice = $globalPromoPrice;
			}
		}

		return $bestPrice;
	}
}
}