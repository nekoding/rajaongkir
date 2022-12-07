<?php

namespace Nekoding\Rajaongkir\Contracts;

interface ISearch
{
    public function setUp(array $data = []): self;

    public function search(string $search): array;
}
