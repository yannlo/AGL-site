<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this -> table("users",['id'=>false, "primary_key" => ["cni"] ])
        -> addColumn("cni","string",["limit"=>11])
        -> addColumn("firstName","string")
        -> addColumn("lastName","string")
        -> addColumn("email","string")
        -> addColumn("password","string")
        -> addColumn("address","string")
        -> addColumn("phoneNumber","string",["limit"=>10])
        ->create();
    }
}
