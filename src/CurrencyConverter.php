<?php

class CurrencyConverter {
    private $rates;

    public function __construct($rates) {
        $this->rates = $rates;
    }

    public function convert($amount, $fromCurrency, $toCurrency) {

        $fromRate = $this->findRate($fromCurrency);
        $toRate = $this->findRate($toCurrency);

        if ($fromRate == 0 || $toRate == 0) {
            return 0;
        }

        if ($fromCurrency === 'PLN') {
            return $amount / $toRate;  
        } 
        elseif ($toCurrency === 'PLN') {
            return $amount * $fromRate;
        } 
        else {

            $convertedAmount = $amount / $toRate;
            return $convertedAmount * $fromRate;
        }
    }

    private function findRate($currencyCode) {
        foreach ($this->rates as $rate) {
            if ($rate['code'] === $currencyCode) {
                return $rate['mid'];
            }
        }
        
        return 0;
    }
}
