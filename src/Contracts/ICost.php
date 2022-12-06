<?php

namespace Nekoding\Rajaongkir\Contracts;

interface ICost
{

    public function setOrigin(string $originId): self;

    public function getOrigin(): ?string;

    public function setOriginType(string $originType): self;

    public function getOriginType(): ?string;

    public function setDestination(string $destinationId): self;

    public function getDestination(): ?string;

    public function setDestinationType(string $destinationType): self;

    public function getDestinationType(): ?string;

    public function setWeight(int $gram): self;

    public function getWeight(): ?int;

    public function setCourier(string $courier): self;

    public function getCourier(): ?string;

    public function setLength(float $cm): self;

    public function getLength(): ?float;

    public function setWidth(float $cm): self;

    public function getWidth(): ?float;

    public function setHeight(float $cm): self;

    public function getHeight(): ?float;

    public function setDiameter(float $cm): self;

    public function getDiameter(): ?float;
}
