<?php

namespace App\Service\Converter\Converters;

use App\Models\ConverterType;
use App\Service\Converter\AbstractConverterUpdater;
use Illuminate\Support\Facades\Http;

use function json_decode;

class OERConverterUpdater extends AbstractConverterUpdater
{
    public function setConverterType(): int
    {
        return ConverterType::OER;
    }

    public function updateConverterInfo(): void
    {
        $response = Http::get($this->getApiUrl() . '/latest.json?app_id=' . $this->getApiKey());
        $responseArray = $this->parseResponse($response->body());

        $this->mainForex = $responseArray['base'];

        $forexCostArray = [];

        foreach ($responseArray['rates'] as $currency => $value) {
            $forexCostArray[] = [
                'converter_types' => ConverterType::OER,
                'currency' => $currency,
                'forex' => (float)$value
            ];
        }

        $this->forexCostArray = $forexCostArray;
    }

    /** @return array{
     *  base: string,
     *  rates: array<string, float>
     * }
     */
    public function parseResponse(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}
