<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class SeedUser extends AbstractSeed
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
        $faker = Factory::create("fr_FR");
        $users = [];
        
        $users[] = [
            "cni" => "A0123456789",
            "firstName" => "EHUI",
            "lastName" => "Yann-Loïc",
            "email" => "ehui.yann729@gmail.com",
            "password" => password_hash("YannLo@01", PASSWORD_DEFAULT),
            "address" => "Riviéra palmeraie, Cocody, Abidjan, Cote d'Ivoire 00225",
            "phoneNumber" => "0789787224"
        ];

        for ($i=0; $i < 30; $i++) { 
            $users[] = [
                "cni" => $faker -> regexify("/[a-zA-Z][0-9]{10}/"),
                "firstName" => $faker -> firstName(),
                "lastName" => $faker -> lastName(),
                "email" => $faker->freeEmail(),
                "password" => password_hash($faker->password(8,16),PASSWORD_DEFAULT),
                "address" => $faker -> address(),
                "phoneNumber" => $faker -> regexify("/(01|05|07)[0-9]{8}/")
            ];
        }

        $this ->table("users")
         -> insert($users)
         -> saveData();
    }
}
