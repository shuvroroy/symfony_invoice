<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Shuvro Roy');
        $user->setEmail('shuvro@gmail.com');
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'password'
            )
        );
        $manager->persist($user);
        $manager->flush();
    }
}
