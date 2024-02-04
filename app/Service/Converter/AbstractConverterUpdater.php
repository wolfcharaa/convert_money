<?php

namespace App\Service\Converter;

abstract class AbstractConverterUpdater implements ConverterUpdaterInterface
{
    protected string $apiUrl;
    protected string $apiKey;
    protected array $forexCostArray;
    protected string $mainForex;

    public function __construct()
    {
        $this->apiUrl = $this->setApiUrl();
        $this->apiKey = $this->setApiKey();
    }

    abstract protected function setApiUrl(): string;
    abstract protected function setApiKey(): string;

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
}
