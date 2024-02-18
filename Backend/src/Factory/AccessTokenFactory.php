<?php

namespace App\Factory;

use App\Entity\AccessToken;
use App\Repository\AccessTokenRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AccessToken>
 *
 * @method        AccessToken|Proxy                     create(array|callable $attributes = [])
 * @method static AccessToken|Proxy                     createOne(array $attributes = [])
 * @method static AccessToken|Proxy                     find(object|array|mixed $criteria)
 * @method static AccessToken|Proxy                     findOrCreate(array $attributes)
 * @method static AccessToken|Proxy                     first(string $sortedField = 'id')
 * @method static AccessToken|Proxy                     last(string $sortedField = 'id')
 * @method static AccessToken|Proxy                     random(array $attributes = [])
 * @method static AccessToken|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AccessTokenRepository|RepositoryProxy repository()
 * @method static AccessToken[]|Proxy[]                 all()
 * @method static AccessToken[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AccessToken[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AccessToken[]|Proxy[]                 findBy(array $attributes)
 * @method static AccessToken[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AccessToken[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AccessTokenFactory extends ModelFactory
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
    // Generate a random number of days between -5 and 5
    $randomDays = random_int(-5, 5);
    $operator = $randomDays >= 0 ? '+' : '';
    $expiresAt = new \DateTimeImmutable("$operator$randomDays days");
    
    return [
        'ownedBy' => UserFactory::new(),
        'expiresAt' => $expiresAt,
    ];
}

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(AccessnToken $accessToken): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AccessToken::class;
    }
}
