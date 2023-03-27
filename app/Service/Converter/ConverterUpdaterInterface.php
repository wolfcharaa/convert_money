<?php

namespace App\Service\Converter;

use App\Service\Converter\Converters\LayerConverterUpdater;
use App\Service\Converter\Converters\OERConverterUpdater;

interface ConverterUpdaterInterface
{

    const ConverterPointer = [
        "OER" => OERConverterUpdater::class,
        "layer" => LayerConverterUpdater::class
    ];
    /**
     * Получить актуальные значения из АПИ и записать
     * их в переменную $forexCostArray - массив [дополнительная валюта => стоимость основной]
     * и заполнить переменную $mainForex - основная валюта
     * @return void
     */
    function updateConverterInfo(): void;

    /**
     * Возвращает массив стоимости основной валюты
     * @return array
     */
    function getForexCostArray(): array;

    /**
     *  Возвращает основную валюту
     * @return string
     */
    function getMainForex(): string;
}
