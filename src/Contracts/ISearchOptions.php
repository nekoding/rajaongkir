<?php

namespace Nekoding\Rajaongkir\Contracts;

use Nekoding\Rajaongkir\Resources\AbstractApiResource;

interface ISearchOptions
{
    
    /**
     * load search configuration
     *
     * @param array $config
     * @return self
     */
    public function setConfig(array $config): ISearch;

    /**
     * get search configuration
     *
     * @return array
     */
    public function getConfig(): array;

    /**
     * load search keys
     *
     * @param array $keys
     * @return self
     */
    public function setKeys(array $keys): self;

    /**
     * get search keys
     *
     * @return array
     */
    public function getKeys(): array;

    /**
     * load search threshold
     *
     * @param float $threshold
     * @return self
     */
    public function setThreshold(float $threshold): self;

    /**
     * get search threshold
     *
     * @return float
     */
    public function getThreshold(): float;
}
