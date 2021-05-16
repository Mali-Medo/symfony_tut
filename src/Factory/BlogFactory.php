<?php

namespace App\Factory;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Repository\BlogRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;
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

    public function notPosted():self
    {
        return $this->addState(['postedAt' => null]);
    }

    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->realText(50),
            'description' => self::faker()->realTextBetween(20, 150),
            'blogText' => self::faker()->paragraphs(
                self::faker()->numberBetween(1, 4),
                true
            ),
            'postedAt' => self::faker()->dateTimeBetween('-100 days', '-1 minute'),
            'votes' => rand(-20, 50),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
        //     ->afterInstantiate(function(Blog $blog)
        ;
    }

    protected static function getClass(): string
    {
        return Blog::class;
    }
}
