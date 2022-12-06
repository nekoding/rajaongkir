<?php

namespace Nekoding\Rajaongkir\Utils;

abstract class AbstractResponse
{

    protected $keys = "results";

    public function getKeys(): string
    {
        return $this->keys;
    }

    public function setKeys(string $keys): self
    {
        $this->keys = $keys;
        return $this;
    }
}
