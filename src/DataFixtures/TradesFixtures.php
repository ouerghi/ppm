<?php

namespace App\DataFixtures;

use App\Entity\Trades;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TradesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $activity = $manager->getRepository('App:Activity')->find(1);
        $activity1 = $manager->getRepository('App:Activity')->find(2);
        $activity2 = $manager->getRepository('App:Activity')->find(3);
        $trades = [
            'Mouture et transformation du blé',
            'Mouture des épices et des fruits secs',
            'Production des dérivés du lait'
        ];
        $trades1 = [
            'Fabrication de charpetre pour bâtiment',
            'Transformation du marbre naturel, production et transformation de marbre artificiel',
            'Fabrication et transformation de plâtre'
        ];
        $trades2 = [
            'Menuiserie de toutes sortes à l\'exclusion de la menuiserie artisanale',
            'Fabrication de barques de peche et composantes',
            'Fabrication de jouets et d\'objets d\'art en bois'
        ];

        foreach ($trades as $trade)
        {
            $trad = new Trades();
           $trad->setName($trade);
           $trad->setActivities($activity);
           $manager->persist($trad);
        }
        foreach ($trades1 as $trade)
        {
            $trad = new Trades();
            $trad->setName($trade);
            $trad->setActivities($activity1);
            $manager->persist($trad);
        }
        foreach ($trades2 as $trade)
        {
            $trad = new Trades();
            $trad->setName($trade);
            $trad->setActivities($activity2);
            $manager->persist($trad);
        }

        $manager->flush();
    }
}
