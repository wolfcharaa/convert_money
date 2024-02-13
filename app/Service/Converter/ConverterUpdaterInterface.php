<?php

declare(strict_types=1);

namespace App\Service\Converter;

use App\Models\ConverterType;
use App\Service\Converter\Converters\LayerConverterUpdater;
use App\Service\Converter\Converters\OERConverterUpdater;

interface ConverterUpdaterInterface
{
    public const CONVERTER_POINTER = [
        ConverterType::OER => OERConverterUpdater::class,
        ConverterType::LAYER => LayerConverterUpdater::class
    ];

    /**
     * Получить актуальные значения из АПИ и записать
     * их в переменную $forexCostArray - массив [дополнительная валюта => стоимость основной]
     * и заполнить переменную $mainForex - основная валюта
     * @return void
     */
    public function updateConverterInfo(): void;

    /**
     * Возвращает массив стоимости основной валюты
     */
    public function getForexCostToSave(): iterable;

    /**
     * Возвращает основную валюту
     */
    public function getMainForex(): string;

    public function setConverterType(): int;

    public function parseResponse(string $json): array;
}
