<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encode;
    public function __construct(UserPasswordEncoderInterface $encode){
        $this->encode = $encode;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('root')
            ->setEmail('root@root.com')
            ->setPassword($this->encode->encodePassword($user, 'rootroot'))
            ->setRoles(['ROLE_USER']);
            $manager->persist($user);
        
        $admin = new User();
        $admin->setUsername('admin')
            ->setEMail('admin@admin.com')
            ->setPassword($this->encode->encodePassword($user, 'adminadmin'))
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $manager->persist($admin);

            $manager->flush();
    }
}
