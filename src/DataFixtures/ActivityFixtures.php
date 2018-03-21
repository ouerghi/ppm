<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $act = [
            'Activités de métiers de fabrication alimentaire',
            'Activités de métiers de fabrication de matériaux de construction,de céramique et du verre',
            'Activités de métiers de fabrication du bois, de liège, de halfa et de palme'
        ];
        // $product = new Product();
        // $manager->persist($product);
        foreach ($act as $acti)
        {
            $activitys = new Activity();
            $activitys->setName($acti);
            $manager->persist($activitys);
        }
        $manager->flush();
    }
}
