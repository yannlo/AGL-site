<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class ArticleTable extends AbstractMigration
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
        $this -> table("articles")
            -> addColumn("title", 'string', ["limit" => 100])
            -> addColumn("slug", 'string', ["limit" => 255])
            -> addColumn("content", 'text', ["limit" => MysqlAdapter::TEXT_MEDIUM])
            ->create();
    }
}
