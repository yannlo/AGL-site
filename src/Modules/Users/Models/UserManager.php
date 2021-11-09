<?php

namespace YannLo\Agl\Modules\Users\Models;

use YannLo\Agl\Modules\Users\App\User;


class UserManager
{
    public function __construct(private \PDO $pdo)
    {}

    public function getOnce(mixed $value, string $columnName = "cni"): ?User
    {
        $query = $this -> pdo -> prepare("SELECT * FROM users WHERE $columnName = :$columnName");
        try
        {
            $query->execute([
                $columnName => $value
            ]);
        }
        catch (\PDOException $e)
        {
            throw new \RuntimeException('invalid column name');
            return null;
        }
        
        $result = $query->fetch();

        if (!is_array($result)) {
            throw new \InvalidArgumentException('invalid cni');
            return null;
        }

        return new User($result);
        
    }

    public function create(User $user): void
    {

        $query = $this-> pdo -> prepare("INSERT INTO users (cni, firstName, lastName, email, password, address, phoneNumber) VALUES (:cni, :firstName, :lastName, :email, :password, :address, :phoneNumber)");
        
        try
        {
            $query ->execute([
                "cni" => $user -> cni(),
                "firstName" => $user -> firstName(),
                "lastName" => $user -> lastName(),
                "email" => $user-> email(),
                "password" => $user->password(),
                "address" => $user -> address(),
                "phoneNumber" => $user -> phoneNumber()
            ]);
        }
        catch (\PDOException $e)
        {
            throw new \RuntimeException($e->getMessage());('invalid column name');
            return ;
        }

    }

    public function update(User $user) : void
    {

        $query = $this-> pdo -> prepare("UPDATE users SET (cni = :cni, firstName = :firstName, lastName = :lastName, email = :email, password = :password, address = :address, phoneNumber = :phoneNumber)");

        try
        {
            $query ->execute([
                "cni" => $user -> cni(),
                "firstName" => $user -> firstName(),
                "lastName" => $user -> lastName(),
                "email" => $user-> email(),
                "password" => $user->password(),
                "address" => $user -> address(),
                "phoneNumber" => $user -> phoneNumber()
            ]);
        }
        catch (\PDOException $e)
        {
            throw new \RuntimeException($e->getMessage());('invalid column name');
            return ;
        }
    }

    public function delete(User $user): void
    {
        $query = $this-> pdo -> prepare("DELETE FROM users WHERE cni = :cni");

        try
        {
            $query ->execute([
                "cni" => $user -> cni()
            ]);
        }
        catch (\PDOException $e)
        {
            throw new \RuntimeException($e->getMessage());('invalid column name');
            return ;
        }
    }
}