<?php

namespace App\Service\Converter\Converters;

use App\Service\Converter\AbstractConverterUpdater;
use App\Service\Converter\ConverterUpdaterInterface;
use Illuminate\Support\Facades\Http;

class OERConverterUpdater extends AbstractConverterUpdater implements ConverterUpdaterInterface
{
    const API_URL = 'https://openexchangerates.org/api/latest.json';
    const ENV_KEY = 'OER_CONVERTER_USER_ID';
    function updateConverterInfo(): void
    {
        $userId = $this->checkAndReturnUserId();
        $response = Http::get(self::API_URL . '?app_id=' . $userId);
        $responseArray = $response->json();
        $this->mainForex = $responseArray['base'];
        $this->forexCostArray = $responseArray['rates'];
    }

    private function checkAndReturnUserId(): string
    {
        /** @var string|false $userId */
        $userId = env(self::ENV_KEY, false);
        if (!$userId) {
            throw new \JsonException('В .env отсутсвует ключ ' . self::ENV_KEY);
        }
        return $userId;
    }
}
