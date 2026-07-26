<?php

namespace App\Services;

class CurrencyConverter
{
    protected $rates = [
        'USD' => 1.08,  // 1 Euro = 1.08 Dollar
        'XOF' => 655.96 // 1 Euro = 655.96 Franc CFA
    ];

    /**
     * Convertit un montant en EUR vers une autre devise
     */
    public function convert(float $amountInEur, string $targetCurrency): float
    {
        // Si la devise n'est pas supportée, on retourne le montant de base
        if (!array_key_exists($targetCurrency, $this->rates)) {
            return $amountInEur;
        }

        return $amountInEur * $this->rates[$targetCurrency];
    }
}
