<?php


namespace YannLo\Basic\Modules\Declarations\Models;

use YannLo\Basic\Modules\Declarations\Apps\Declaration;


class DeclarationManager
{
    public function __construct(private \PDO $pdo)
    {

    }

    public function getAllByPage(int $page, int $nbrElement = 20): array
    {
        return [];
    }

    public function getOnce(int $id): Declaration
    {
        return new Declaration();
    }

    public function create(Declaration $declaration): void
    {

    }

    public function update(Declaration $declaration): void
    {

    }

    public function delete(Declaration $declaration): void
    {
        
    }
}