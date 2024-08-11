<?php

/**
 * @file
 * CurrencyConverter class.
 */

/**
 * Handles currency conversions using provided exchange rates.
 */
class CurrencyConverter {
  /**
   * @var array 
   *   Holds currency rates.
   */
  private $rates;

  /**
   * Constructor.
   *
   * @param array $rates 
   *   Array of currency rates.
   */
  public function __construct(array $rates) {
    $this->rates = $rates;
  }

  /**
   * Converts a given amount from one currency to another.
   *
   * @param float $amount 
   *   The amount to convert.
   * @param string $fromCurrency 
   *   The currency code to convert from.
   * @param string $toCurrency 
   *   The currency code to convert to.
   * 
   * @return float 
   *   The converted amount.
   */
  public function convert(float $amount, string $fromCurrency, string $toCurrency): float {
    $fromRate = $this->findRate($fromCurrency);
    $toRate = $this->findRate($toCurrency);

    if ($fromRate == 0 || $toRate == 0) {
      return 0;
    }

    if ($fromCurrency === "PLN") {
      return $amount / $toRate;
    } 
    elseif ($toCurrency === "PLN") {
      return $amount * $fromRate;
    } 
    else {
      $amountInPLN = $amount / $toRate;
      return $amountInPLN * $fromRate;
    }
  }

  /**
   * Finds the exchange rate for a given currency code.
   *
   * @param string $currencyCode 
   *   The currency code to find the rate for.
   * 
   * @return float 
   *   The exchange rate.
   */
  private function findRate(string $currencyCode): float {
    foreach ($this->rates as $rate) {
      if ($rate["code"] === $currencyCode) {
        return $rate["mid"];
      }
    }

    return 0;
  }
}
