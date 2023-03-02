<?php

namespace App\Service\Converter\Converters;

use App\Service\Converter\AbstractConverterUpdater;
use App\Service\Converter\ConverterUpdaterInterface;
use Illuminate\Support\Facades\Http;

class LayerConverterUpdater extends AbstractConverterUpdater implements ConverterUpdaterInterface
{
    const LAYER_API_URL = 'https://api.apilayer.com/currency_data/live?base=USD';
    const ENV_KEY = 'LAYER_CONVERTER_USER_ID';

    function updateConverterInfo(): void
    {
        $userId = $this->checkAndReturnUserId();
        $response = Http::withHeaders(['apikey'=>$userId])->get(self::LAYER_API_URL);
        var_dump($response);
        $responseArray = $response->json();
        $this->mainForex = $responseArray['source'];
        $this->forexCostArray = $this->forexCostRecreate($responseArray['quotes']);
    }

    private function forexCostRecreate(array $costFromApi): array
    {
        $rideArray = [];
        foreach ($costFromApi as $key => $value) {
            $newKey = substr($key, 3);
            $rideArray[$newKey] = $value;
        }
        return $rideArray;
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