<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i <= 50; $i++) { 
           $client = new Client();
           $client->setLastName($i."_LASTNAME");
           $client->setFirstName($i."_firstname");
           $client->setUserName($i."_username");
           $manager->persist($client);
           
        }
        

        $manager->flush();
    }
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
