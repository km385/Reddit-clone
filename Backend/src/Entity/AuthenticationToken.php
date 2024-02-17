<?php

namespace App\Entity;

use App\Repository\AuthenticationTokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthenticationTokenRepository::class)]
class AuthenticationToken
{
    public const PREFIX_PERSONAL_ACCESS_TOKEN = 'rpa_';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $expiresAt = null;

    #[ORM\Column(length: 68)]
    private ?string $token = null;

    // #[ORM\Column]
    // private array $scopes = [];

    #[ORM\ManyToOne(inversedBy: 'authenticationTokens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ownedBy = null;

    public function __construct(string $tokenType = self::PREFIX_PERSONAL_ACCESS_TOKEN)
    {
        // $this->createdAt = new \DateTime();
        $this->token = $tokenType.bin2hex(random_bytes(32));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeImmutable $expiresAt): static
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    // public function getScopes(): array
    // {
    //     return $this->scopes;
    // }

    // public function setScopes(array $scopes): static
    // {
    //     $this->scopes = $scopes;

    //     return $this;
    // }

    public function getOwnedBy(): ?User
    {
        return $this->ownedBy;
    }

    public function setOwnedBy(?User $ownedBy): static
    {
        $this->ownedBy = $ownedBy;

        return $this;
    }
}
