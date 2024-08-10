<?php

class CurrencyRateFetcher {
  private $apiUrl = "http://api.nbp.pl/api/exchangerates/tables/A?format=json";

  public function getRates() {
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

  public function getCurrencies() {
    $rates = $this->getRates();
    return array_map(function ($rate) {
      return [
        'code' => $rate['code'],
        'name' => $rate['currency']
      ];
    }, $rates);
  }
  
}
