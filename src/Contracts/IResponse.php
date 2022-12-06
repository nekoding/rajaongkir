<?php

namespace Nekoding\Rajaongkir\Contracts;

interface IResponse
{

    public function count(): int;

    public function first(): array;

    public function last(): array;

    public function nth(int $index): array;

    public function get(): array;

    public function slice(int $start, int $length = null): array;
}
