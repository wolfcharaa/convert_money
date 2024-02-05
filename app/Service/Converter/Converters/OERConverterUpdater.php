<?php

namespace App\Service\Converter\Converters;

use App\Models\ConverterType;
use App\Service\Converter\AbstractConverterUpdater;
use Illuminate\Support\Facades\Http;

class OERConverterUpdater extends AbstractConverterUpdater
{
    protected int $converterType = ConverterType::OER;
    const API_URL = 'https://openexchangerates.org/api/latest.json';
    const ENV_KEY = 'OER_CONVERTER_USER_ID';
    public function updateConverterInfo(): void
    {
        $response = Http::get($this->getApiUrl() . '?app_id=' . $this->getApiKey());
        $responseArray = $response->json();

        $this->mainForex = $responseArray['base'];
        $this->forexCostArray = $responseArray['rates'];
    }
}
