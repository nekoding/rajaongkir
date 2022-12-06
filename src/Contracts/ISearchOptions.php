<?php

namespace Nekoding\Rajaongkir\Contracts;

use Nekoding\Rajaongkir\Resources\AbstractApiResource;

interface ISearchOptions
{

    /**
     * set search keys value
     *
     * @param   $keys
     * @return AbstractApiResource
     */
    public function setSearchKeys(array $keys): AbstractApiResource;
    
    /**
     * set search threshold value
     *
     * @param  float|int $threshold
     * @return AbstractApiResource
     */
    public function setSearchThreshold(float $threshold): AbstractApiResource;

}