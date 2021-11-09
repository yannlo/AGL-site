<?php

namespace YannLo\Agl\Modules\Tools\App;

abstract class Account
{

    use \YannLo\Agl\Modules\Tools\App\NameVerified;
    //variables
    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected string $password;


    //Traits

    // getters
    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    // setters
    public function setFirstName(string $firstName): void
    {
        $this -> verfierName($firstName);

        $this -> firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this -> verfierName($lastName);

        $this -> lastName = $lastName;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('invalid address format');
            return;
        }

        $this ->email = $email;
    }

    public function setPassword(string $password): void
    {
        if (strlen($password) <= 32) {
            if (preg_match("/([A-Za-z\d@$!%*?&]{8,16})/", $password)<1) {
                throw new \InvalidArgumentException('invalid registration number');
                return;
            } 
        }
        $this -> password = $password;
    }
}
