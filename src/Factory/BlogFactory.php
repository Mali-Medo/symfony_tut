<?php

namespace App\Factory;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Blog|Proxy createOne(array $attributes = [])
 * @method static Blog[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Blog|Proxy find($criteria)
 * @method static Blog|Proxy findOrCreate(array $attributes)
 * @method static Blog|Proxy first(string $sortedField = 'id')
 * @method static Blog|Proxy last(string $sortedField = 'id')
 * @method static Blog|Proxy random(array $attributes = [])
 * @method static Blog|Proxy randomOrCreate(array $attributes = [])
 * @method static Blog[]|Proxy[] all()
 * @method static Blog[]|Proxy[] findBy(array $attributes)
 * @method static Blog[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Blog[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BlogRepository|RepositoryProxy repository()
 * @method Blog|Proxy create($attributes = [])
 */
final class BlogFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'title' => 'Missing pants',
            'slug' => 'missing-pants-' . rand(0, 1000),
            'description' => 'Does anyone have a spell to call your pants back?',
            'blogText' => <<<EOF
Hi! So... I'm having a *weird* day. Yesterday, I cast a spell to make
my dishes wash themselves. But while I was casting it,
I slipped a little and I think `I also hit my pants with the spell`.

When I woke up this morning, I caught a quick glimpse of my pants
opening the front door and walking out! I've been out all afternoon
(with no pants mind you) searching for them.

Does anyone have a spell to call your pants back?
EOF,
            'postedAt' => rand(1, 10) > 2 ? new \DateTime(sprintf('-%d days', rand(1, 100))) : null,
            'votes' => rand(-20, 50),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Blog $blog) {})
        ;
    }

    protected static function getClass(): string
    {
        return Blog::class;
    }
}
