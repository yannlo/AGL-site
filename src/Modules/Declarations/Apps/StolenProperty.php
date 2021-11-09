<?php

namespace YannLo\Basic\Modules\Declarations\Apps;

class StolenProperty
{
    // variables
    private string $matricule;
    private string $color;
    private string $brand;
    private string $model;
    private string $type;
    private string $description;

    // constantes
    const BIKE = "bike";
    const BICYCLE = "bicycle";
    const CAR = "car";

    // traites
    use \YannLo\Basic\Modules\Tools\Apps\Hydration;

    // constructor
    public function __construct(array $data = [])
    {
        $this -> hydrate($data);
    }

    // getters
    public function matricule(): string
    {
        return $this->matricule;
    }

    public function color(): string
    {
        return $this->color;
    }

    public function brand(): string
    {
        return $this->brand;
    }

    public function model(): string
    {
        return $this->model;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function description(): string
    {
        return $this->description;
    }

    // setters
    public function setMatricule(string $matricule): void
    {
        $this->matricule = $matricule;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
