<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;

class InvoiceFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager)
    {
        $manager->flush();
    }
}
