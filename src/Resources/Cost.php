<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\ICost;
use ReflectionClass;
use ReflectionProperty;

class Cost extends AbstractApiTarif implements ICost
{

    private $origin;
    private $originType;
    private $destination;
    private $destinationType;
    private $weight;
    private $courier;
    private $length;
    private $width;
    private $height;
    private $diameter;

    public function setOrigin(string $originId): ICost
    {

        $this->origin = $originId;
        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOriginType(string $originType): ICost
    {
        $this->originType = $originType;
        return $this;
    }

    public function getOriginType(): ?string
    {
        return $this->originType;
    }

    public function setDestination(string $destinationId): ICost
    {
        $this->destination = $destinationId;
        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestinationType(string $destinationType): ICost
    {
        $this->destinationType = $destinationType;
        return $this;
    }

    public function getDestinationType(): ?string
    {
        return $this->destinationType;
    }

    public function setWeight(int $gram): ICost
    {
        $this->weight = $gram;
        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setCourier(string $courier): ICost
    {
        $this->courier = $courier;
        return $this;
    }

    public function getCourier(): ?string
    {
        return $this->courier;
    }

    public function setLength(float $cm): ICost
    {
        $this->length = $cm;
        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setWidth(float $cm): ICost
    {
        $this->width = $cm;
        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setHeight(float $cm): ICost
    {
        $this->height = $cm;
        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setDiameter(float $cm): ICost
    {
        $this->diameter = $cm;
        return $this;
    }

    public function getDiameter(): ?float
    {
        return $this->diameter;
    }

    private function buildFormData()
    {
        $reflection = new ReflectionClass($this);
        $props = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);

        $formData = [];
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            if (!is_null($prop->getValue($this))) {
                $formData[$prop->getName()] = $prop->getValue($this);
            }
        }

        $this->body = $formData;
    }

    public function setData(array $data): AbstractApiTarif
    {
        $reflection = new ReflectionClass($this);

        foreach ($data as $key => $value) {
            $prop = $reflection->getProperty($key);
            $prop->setAccessible(true);
            $prop->setValue($this, $value);
        }

        return $this;
    }

    public function get(): array
    {
        $this->buildFormData();

        $url = $this->httpClient->buildUrl("/cost");

        $this->httpClient::setFormParams($this->body);
        $res = $this->httpClient->request("POST", $url)->getBody();

        if ($res['rajaongkir']['status']['code'] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($res['rajaongkir']['status']['description']);
        }

        return $res["rajaongkir"];
    }
}
