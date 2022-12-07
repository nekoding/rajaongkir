<?php

namespace Nekoding\Rajaongkir\Contracts;

interface IResponseSearch
{
    /**
     * count result data
     *
     * @return integer
     */
    public function count(): int;

    /**
     * get first data
     *
     * @return array
     */
    public function first(): array;

    /**
     * get last data
     *
     * @return array
     */
    public function last(): array;

    /**
     * get n-data from index
     *
     * @param integer $index
     * @return array
     */
    public function nth(int $index): array;

    /**
     * get result
     *
     * @return array
     */
    public function get(): array;
}
