<?php

namespace App\Factory;

use App\Entity\Community;
use App\Repository\CommunityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Community>
 *
 * @method        Community|Proxy create(array|callable $attributes = [])
 * @method static Community|Proxy createOne(array $attributes = [])
 * @method static Community|Proxy find(object|array|mixed $criteria)
 * @method static Community|Proxy findOrCreate(array $attributes)
 * @method static Community|Proxy first(string $sortedField = 'id')
 * @method static Community|Proxy last(string $sortedField = 'id')
 * @method static Community|Proxy random(array $attributes = [])
 * @method static Community|Proxy randomOrCreate(array $attributes = [])
 * @method static CommunityRepository|RepositoryProxy repository()
 * @method static Community[]|Proxy[] all()
 * @method static Community[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Community[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Community[]|Proxy[] findBy(array $attributes)
 * @method static Community[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Community[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class CommunityFactory extends ModelFactory
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
            'name' => self::faker()->unique()->text(rand(5, 21)),
            'description' => self::faker()->paragraph(),
            'sendWelcomeMessage' => self::faker()->boolean(),
            'isNSFW' => self::faker()->boolean(),
            'status' => self::faker()->randomElement([
                Community::STATUS_SUBRE_PRIVATE,
                Community::STATUS_SUBRE_RESTRICTED,
                Community::STATUS_SUBRE_PUBLIC
            ]),
            'creator' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Community $community): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Community::class;
    }
}
