<?php


namespace AppBundle\DataFixtures;

use AppBundle\Entity\Product;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Subscription;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        for ($i = 0; $i < 20; $i++) {

            $product = new Product();
            $contact = new Contact();
            $subscription = new Subscription();

            $product->setLabel('product '.$i);

            $contact = new Contact();
            $contact->setName('contact' .$i);

            $contact->setFirstName('contact' .$i);

         
            $manager->persist($contact);
            $manager->persist($product);
        }

        $manager->flush();
    }
}