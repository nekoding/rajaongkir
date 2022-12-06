<?php

namespace Nekoding\Rajaongkir\Contracts;

interface ISearch
{
    public function setUp(array $data = []): self;

    public static function setSearchOptions(array $options);

    public static function setSearchKeys(array $keys);

    public static function getSearchKeys(): array;

    public static function setSearchThreshold(float $threshold);

    public static function getSearchThreshold(): float;

    public function loadSearchOptions(array $options): self;

    public function search(string $search): array;
}
