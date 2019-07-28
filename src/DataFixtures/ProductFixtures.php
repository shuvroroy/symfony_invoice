<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager)
    {
        for ($i = 1; $i <= 200; $i++) {
            $product = new Product();
            $product->setName('Product-'. $i);
            $product->setDescription($this->faker->sentence);
            $product->setUnitPrice($this->faker->randomFloat(2, 100, 500));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
