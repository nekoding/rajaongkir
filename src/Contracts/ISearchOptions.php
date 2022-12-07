<?php

namespace Nekoding\Rajaongkir\Contracts;

use Nekoding\Rajaongkir\Resources\AbstractApiResource;

interface ISearchOptions
{

    /**
     * set search options
     *
     * @param array $options
     * @return void
     */
    public static function setSearchOptions(array $options);

    /**
     * get search options
     *
     * @return array
     */
    public static function getSearchOptions(): array;

    /**
     * set search keys
     *
     * @param array $keys
     * @return void
     */
    public static function setSearchKeys(array $keys);

    /**
     * get search keys
     *
     * @return array
     */
    public static function getSearchKeys(): array;

    /**
     * set search threshold value
     *
     * @param float $threshold
     * @return void
     */
    public static function setSearchThreshold(float $threshold);

    /**
     * get search threshold value
     *
     * @return float
     */
    public static function getSearchThreshold(): float;

    /**
     * load search options
     *
     * @param array $options
     * @return self
     */
    public function setOptions(array $options): ISearch;

    /**
     * get search options
     *
     * @return array
     */
    public function getOptions(): array;

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
