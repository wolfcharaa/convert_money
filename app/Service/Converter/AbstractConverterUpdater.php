<?php

namespace App\Service\Converter;

abstract class AbstractConverterUpdater
{
    protected array  $forexCostArray;
    protected string $mainForex;

    function getForexCostArray(): array
    {
        return $this->forexCostArray;
    }

    function getMainForex(): string
    {
        return $this->mainForex;
    }
}
