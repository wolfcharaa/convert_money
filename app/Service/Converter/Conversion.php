<?php

namespace App\Service\Converter;

use App\Models\ForexCostActual;

class Conversion
{

    /**
     * @param string $from
     * @param string $to
     * @param float $count
     * @return int|float
     */
    public function convertForex(string $fromName, string $toName, float $count) {
        /** @var ForexCostActual $forexCost */
        $forexCost = ForexCostActual::query()->latest()->first();
        $fromValue = json_decode($forexCost->forex_cost_array, true)[$fromName];
        $toValue = json_decode($forexCost->forex_cost_array, true)[$toName];
        $result = $toValue * $count/$fromValue;
        return $result;
    }

}