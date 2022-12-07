<?php

namespace Nekoding\Rajaongkir\Contracts;

interface ISearch
{    
    /**
     * setup search object
     *
     * @param  array $data
     * @return self
     */
    public function setUp(array $data = []): self;
    
    /**
     * search data
     *
     * @param  string $search
     * @return array
     */
    public function search(string $search): array;
}
