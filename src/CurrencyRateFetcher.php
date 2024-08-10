<?php

/**
 * @file
 * Fetches currency exchange rates from the NBP API.
 */

/**
 * CurrencyRateFetcher retrieves and processes currency rate data from NBP.
 */
class CurrencyRateFetcher {

  /**
   * @var string 
   *   API URL to fetch currency rates.
   */
  private string $apiUrl = "http://api.nbp.pl/api/exchangerates/tables/A?format=json";

  /**
   * Fetches and returns currency rates including PLN.
   *
   * @return array 
   *   List of currency rates with PLN added.
   */
  public function getRates(): array {
    $ch = curl_init($this->apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    $rates = $data[0]['rates'];

    array_unshift($rates, [
      'currency' => 'złoty polski',
      'code' => 'PLN',
      'mid' => 1
    ]);

    return $rates;
  }

  /**
   * Returns a simplified list of currency codes and names.
   *
   * @return array 
   *   List of currencies.
   */
  public function getCurrencies(): array {
    $rates = $this->getRates();
    return array_map(function ($rate) {
      return [
        'code' => $rate['code'],
        'name' => $rate['currency']
      ];
    }, $rates);
  }
}
