<?php

namespace App\Service\Converter;

use App\Models\ConverterType;
use Illuminate\Support\Facades\Redis;

abstract class AbstractConverterUpdater implements ConverterUpdaterInterface
{
    protected int $converterType;
    private string $apiUrl;
    private string $apiKey;
    protected array $forexCostArray;
    protected string $mainForex;
    private ?Redis $redis;

    public function __construct()
    {
        $this->redis = Redis::connection()->client();
        $this->apiUrl = $this->setApiUrl();
        $this->apiKey = $this->setApiKey();
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getForexCostArray(): array
    {
        return $this->forexCostArray;
    }

    public function getMainForex(): string
    {
        return $this->mainForex;
    }

    private function setApiUrl(): string
    {
        $apiUrl = $this->getCacheByApiUrl();

        if ($apiUrl) {
            return $apiUrl;
        }

        $value = (ConverterType::query()->find($this->converterType))->value('url');

        $this->setCacheValue('url', $value);

        return $value;
    }

    private function setApiKey(): string
    {
        $apiKey = $this->getCacheByApiKey();

        if ($apiKey) {
            return $apiKey;
        }

        $value = (ConverterType::query()->find($this->converterType))->value('api_key');

        $this->setCacheValue('key', $value);

        return $value;
    }
    private function getCacheByApiUrl(): ?string
    {
        if ($value = $this->redis->get(static::class . 'url')) {
            return $value;
        }

        return null;
    }

    private function getCacheByApiKey(): ?string
    {
        if ($value = $this->redis->get(static::class . 'key')) {
            return $value;
        }

        return null;
    }

    private function setCacheValue(string $redisKey, string $value): void
    {
        $this->redis->set(static::class . $redisKey, $value);
    }
}
