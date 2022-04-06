<?php

namespace App\DataFixtures;

use App\Entity\Lien;
use App\Entity\Materiel;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LienFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $clients =$manager->getRepository(Client::class)->findAll();
        
        foreach($clients as $client){
            $materiels = $manager->getRepository(Materiel::class)->findby([],null,$limit=mt_rand(1,20),null);
            foreach($materiels as $materiel){
                $lien = new Lien();
                $lien->setQuantite(mt_rand(1,5));
                $lien->setClient($client);
                $lien->setMateriel($materiel);

                $manager->persist($lien);
            }

        }
        $manager->flush();
    }
}
