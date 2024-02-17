<?php

namespace App\Factory;

use App\Entity\AuthenticationToken;
use App\Repository\AuthenticationTokenRepository;
use Carbon\CarbonImmutable;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AuthenticationToken>
 *
 * @method        AuthenticationToken|Proxy                     create(array|callable $attributes = [])
 * @method static AuthenticationToken|Proxy                     createOne(array $attributes = [])
 * @method static AuthenticationToken|Proxy                     find(object|array|mixed $criteria)
 * @method static AuthenticationToken|Proxy                     findOrCreate(array $attributes)
 * @method static AuthenticationToken|Proxy                     first(string $sortedField = 'id')
 * @method static AuthenticationToken|Proxy                     last(string $sortedField = 'id')
 * @method static AuthenticationToken|Proxy                     random(array $attributes = [])
 * @method static AuthenticationToken|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AuthenticationTokenRepository|RepositoryProxy repository()
 * @method static AuthenticationToken[]|Proxy[]                 all()
 * @method static AuthenticationToken[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AuthenticationToken[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AuthenticationToken[]|Proxy[]                 findBy(array $attributes)
 * @method static AuthenticationToken[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AuthenticationToken[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AuthenticationTokenFactory extends ModelFactory
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
        $expiresAt = CarbonImmutable::now()->addDays($randomDays);

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
            // ->afterInstantiate(function(AuthenticationToken $authenticationToken): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AuthenticationToken::class;
    }
}
