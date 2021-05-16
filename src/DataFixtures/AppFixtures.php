<?php

namespace App\DataFixtures;

use App\Factory\BlogFactory;
use App\Factory\CommentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
//        BlogFactory::new()->createMany(20);
//
//        BlogFactory::new()
//            ->notPosted()
//            ->createMany(5)
//        ;
        BlogFactory::createMany(10, ['comments' => CommentFactory::new()->many(0, 15)]);
    }
}
