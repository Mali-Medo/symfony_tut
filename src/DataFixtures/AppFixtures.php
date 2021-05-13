<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use App\Factory\BlogFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        BlogFactory::new()->createMany(20);
    }
}
