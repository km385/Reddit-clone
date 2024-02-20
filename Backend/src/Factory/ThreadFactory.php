<?php

namespace App\Factory;

use App\Entity\Thread;
use App\Repository\ThreadRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Thread>
 *
 * @method        Thread|Proxy                     create(array|callable $attributes = [])
 * @method static Thread|Proxy                     createOne(array $attributes = [])
 * @method static Thread|Proxy                     find(object|array|mixed $criteria)
 * @method static Thread|Proxy                     findOrCreate(array $attributes)
 * @method static Thread|Proxy                     first(string $sortedField = 'id')
 * @method static Thread|Proxy                     last(string $sortedField = 'id')
 * @method static Thread|Proxy                     random(array $attributes = [])
 * @method static Thread|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ThreadRepository|RepositoryProxy repository()
 * @method static Thread[]|Proxy[]                 all()
 * @method static Thread[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Thread[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Thread[]|Proxy[]                 findBy(array $attributes)
 * @method static Thread[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Thread[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ThreadFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'author' => UserFactory::new(),
            'subreddit' => CommunityFactory::new(),
            'isLocked' => self::faker()->boolean(),
            'isNsfw' => self::faker()->boolean(),
            'isSpoiler' => self::faker()->boolean(),
            'title' => self::faker()->text(rand(5, 300)),
            'type' => self::faker()->randomElement([
                Thread::TYPE_POST_TEXT,
                Thread::TYPE_POST_IMAGE,
                Thread::TYPE_POST_LINK,
                Thread::TYPE_POST_REPOST
            ]),
            'status' => self::faker()->randomElement([
                Thread::STATUS_POST_DELETED,
                Thread::STATUS_POST_APPROVED,
                Thread::STATUS_POST_PENDING_APPROVAL,
                Thread::STATUS_POST_REMOVED
            ]),
            // 20% chance for empty post else random string
            'content' => self::faker()->boolean(20) ? self::faker()->text(rand(5, 1000)) : null,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Thread $thread): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Thread::class;
    }
}
