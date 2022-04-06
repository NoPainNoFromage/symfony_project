<?php

namespace App\DataFixtures;

use App\Entity\Materiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MaterielFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 50; $i++) { 
            $materiel = new Materiel();
            $materiel->setName("materielname_".$i);
            $materiel->setReference("REF".$i);
            $materiel->setPrice(mt_rand(100,10000000));
            $manager->persist($materiel);
            
         }

        $manager->flush();
    }
}
