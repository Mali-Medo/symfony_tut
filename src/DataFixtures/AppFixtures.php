<?php

namespace App\DataFixtures;

use App\Factory\ApiTokenFactory;
use App\Factory\BlogFactory;
use App\Factory\CommentFactory;
use App\Factory\TagFactory;
use App\Factory\UserFactory;
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
        TagFactory::createMany(10);

        BlogFactory::createMany(10, function(){
            return [
                'comments' => CommentFactory::new()->many(0, 15),
                'tags' => TagFactory::randomRange(0,6),
            ];
        });

        UserFactory::createMany(10, function () {
            return [
                'apiTokens' => ApiTokenFactory::new()->many(1, 4),
            ];
        });
        UserFactory::new()
            ->withoutBlogUsername()
            ->createMany(10, function () {
                return [
                    'apiTokens' => ApiTokenFactory::new()->many(1, 4),
                ];
            });

        $c = 0;
        UserFactory::new()
            ->giveAdmin()
            ->createMany(3, function () use (&$c) {
                ++$c;
                return [
                    'email' => sprintf('admin%d@admin.com', $c),
                    'apiTokens' => ApiTokenFactory::new()->many(1, 3),
                    ];
            });
    }
}
