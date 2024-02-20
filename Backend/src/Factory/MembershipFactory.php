<?php

namespace App\Factory;

use App\Entity\Membership;
use App\Repository\MembershipRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Membership>
 *
 * @method        Membership|Proxy                     create(array|callable $attributes = [])
 * @method static Membership|Proxy                     createOne(array $attributes = [])
 * @method static Membership|Proxy                     find(object|array|mixed $criteria)
 * @method static Membership|Proxy                     findOrCreate(array $attributes)
 * @method static Membership|Proxy                     first(string $sortedField = 'id')
 * @method static Membership|Proxy                     last(string $sortedField = 'id')
 * @method static Membership|Proxy                     random(array $attributes = [])
 * @method static Membership|Proxy                     randomOrCreate(array $attributes = [])
 * @method static MembershipRepository|RepositoryProxy repository()
 * @method static Membership[]|Proxy[]                 all()
 * @method static Membership[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Membership[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Membership[]|Proxy[]                 findBy(array $attributes)
 * @method static Membership[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Membership[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class MembershipFactory extends ModelFactory
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
            'subreddit' => CommunityFactory::new(),
            'member' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Membership $membership): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Membership::class;
    }
}
