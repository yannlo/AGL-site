<?php

namespace YannLo\Basic\Modules\Declarations\Apps;

use YannLo\Basic\Modules\Users\Apps\User;


/**
 * Declaration
 */
class Declaration
{
    // variables
    private int $id;
    private User $user;
    private StolenProperty $property;
    private \DateTime $dateHour;
    private Location $location;
    private \DateTime $lastModifierDate;
    private string $state;
    private string $userStatus;

    // constants
    const FOUND = "found";
    const NOT_FOUND = " not_found";

    // Traits
    use \YannLo\Basic\Modules\Tools\Apps\Hydration;

    // constructor
    public function __construct(array $data = [])
    {
        $this -> hydrate($data);
    }

    //getters
    public function id(): int
    {
        return $this-> id;
    }

    public function user(): user
    {
        return $this-> user;
    }

    public function property(): StolenProperty
    {
        return $this-> property;
    }

    public function dateHour(): \DateTime
    {
        return $this-> dateHour;
    }

    public function location(): Location
    {
        return $this-> location;
    }

    public function lastModifierDate(): \DateTime
    {
        return $this-> lastModifierDate;
    }

    public function state(): string
    {
        return $this-> state;
    }

    public function userStatus(): string
    {
        return $this-> state;
    }

    // setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function setProperty(StolenProperty $property): void
    {
        $this->property = $property;
    }

    public function setDateHour(\DateTime $dateHour): void
    {
        $this -> dateHour = $dateHour;
    }

    public function setLocation(Location $location): void
    {
        $this -> location = $location;
    }

    public function setLastModifierDate(\DateTime $lastModifierDate): void
    {
        $this -> lastModifierDate = $lastModifierDate;
    }

    public function setState(string $state): void
    {
        $this -> state = $state;
    }

    public function setUserStatus(string $userStatus): void
    {
        if (!in_array($userStatus, [User::ALL, User::VISTIM, User::WITNESS])) {
            throw new \InvalidArgumentException('invalid status');
            return;
        }
        $this -> userStatus = $userStatus;
    }
}
