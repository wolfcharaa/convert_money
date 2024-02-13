<?php

namespace App\Service\Converter;

use App\Models\ConverterType;
use Illuminate\Support\Facades\Redis;

abstract class AbstractConverterUpdater implements ConverterUpdaterInterface
{
    private int $converterType;
    private string $apiUrl;
    private string $apiKey;
    protected array $forexCostArray;
    protected string $mainForex;
    private mixed $redis;

    public function __construct()
    {
        $this->converterType = $this->setConverterType();
        $this->redis = Redis::connection()->client();
        $array = $this->getCacheUrlAndKey();
        $this->apiUrl = $array['url'];
        $this->apiKey = $array['api_key'];
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getForexCostToSave(): iterable
    {
        foreach ($this->forexCostArray as $forexCost) {
            yield $forexCost;
        }
    }

    public function getMainForex(): string
    {
        return $this->mainForex;
    }

    private function getCacheUrlAndKey(): array
    {
        if ($value = $this->redis->get(static::class)) {
            return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        }

        /** @var ConverterType $converterType */
        $converterType = ConverterType::query()->find($this->converterType);

        $this->redis->set(static::class, json_encode($converterType->attributesToArray(), JSON_THROW_ON_ERROR));

        return $converterType->getAttributes();
    }
}
