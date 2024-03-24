<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $produit = new Produit();
        $produit->setNom('Produit1');
        $produit->setDescription('voiture 1');
        $produit->setImage("/image/voiture1.jpg");
        $produit->setStock(10);
        $manager->persist($produit);
        $manager->flush();

        $produit2 = new Produit();
        $produit2->setNom('Produit2');
        $produit2->setDescription('voiture 2');
        $produit2->setImage('/image/voiture2.jpg');
        $produit2->setStock(12);
        $manager->persist($produit2);
        $manager->flush();

        $produit3 = new Produit();
        $produit3->setNom('Produit3');
        $produit3->setDescription('voiture 3');
        $produit3->setImage('/image/voiture3.jpg');
        $produit3->setStock(10);
        $manager->persist($produit3);
        $manager->flush();

        $produit4 = new Produit();
        $produit4->setNom('Produit4');
        $produit4->setDescription('voiture 4');
        $produit4->setImage('/image/voiture4.jpg');
        $produit4->setStock(14);
        $manager->persist($produit4);
        $manager->flush();

        $produit5 = new Produit();
        $produit5->setNom('Produit5');
        $produit5->setDescription('voiture 5');
        $produit5->setImage('/image/voiture5.jpg');
        $produit5->setStock(15);
        $manager->persist($produit5);
        $manager->flush();

        $produit6 = new Produit();
        $produit6->setNom('Produit6');
        $produit6->setDescription('voiture 6');
        $produit6->setImage('/image/voiture6.jpg');
        $produit6->setStock(16);
        $manager->persist($produit6);
        $manager->flush();

        $admin = new Admin();
        $admin->setUsername('SuperAdmin');
        $adminHash = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($adminHash);
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $manager->flush();
    }
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
}
