<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class SeedArticle extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [];
        $faker = Factory::create("FR_fr");

        for ($i = 1; $i <= 12; $i++) {
            $title = $faker -> word() . " " . $faker -> word();
            $data[] = [
                "title" => $title,
                "slug" => $faker -> slug(4),
                "content" => $faker -> text()
            ];
        }

        $this->table("articles")
            -> insert($data)
            -> save();
    }
}
