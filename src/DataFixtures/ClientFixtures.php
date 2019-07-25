<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;

class ClientFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $client = new Client();
            $client->setName($this->faker->name);
            $client->setEmail($this->faker->unique()->safeEmail);
            $client->setPhone($this->faker->phoneNumber);
            $client->setAddress($this->faker->address);

            $manager->persist($client);
        }
        $manager->flush();
    }
}
