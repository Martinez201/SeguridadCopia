<?php

namespace AppBundle\DataFixtures\ORM;



use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::Load(__DIR__.'/fixtures.yml',$manager);
    }


}

// composer require --dev nelmio/alice ^2.1