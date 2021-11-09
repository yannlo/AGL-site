<?php

namespace YannLo\Basic\Modules\Declarations\Apps;

class Location
{
    // variables
    private string $postalCode;
    private string $city;
    private string $common;
    private string $road;

    // traits
    use \YannLo\Basic\Modules\Tools\Apps\Hydration;

    // constructor
    public function __construct(array $data = [])
    {
        $this -> hydrate($data);
    }

    // getters
    public function postalCode(): string
    {
        return $this->postalCode;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function common(): string
    {
        return $this->common;
    }

    public function road(): string
    {
        return $this->road;
    }

    // setters
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setCommon(string $common): void
    {
        $this->common = $common;
    }

    public function setRoad(string $road): void
    {
        $this->road = $road;
    }
}
