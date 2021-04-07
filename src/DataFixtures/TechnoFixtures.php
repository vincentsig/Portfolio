<?php

namespace App\DataFixtures;

use App\Entity\Techno;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TechnoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 15; ++$i) {
            $techno = new Techno();
            $techno->setName('techno ' . $i);

            $manager->persist($techno);
        }
        $manager->flush();
    }
}
