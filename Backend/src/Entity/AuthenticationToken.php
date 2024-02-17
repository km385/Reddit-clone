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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userAddress = null;

    public function __construct(string $tokenType = self::PREFIX_PERSONAL_ACCESS_TOKEN)
    {
        // $this->createdAt = new \DateTime();
        $this->token = $tokenType . bin2hex(random_bytes(32));
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

    /**
     * Check if the session is valid.
     *
     * @param string $userAddress The user's address.
     *
     * @return int Returns an integer code indicating the validity of the session:
     *             - 0: Session is valid.
     *             - 1: Session has expired.
     *             - 2: User address does not match.
     */
    public function isValid(string $userAddress = ""): int
    {
        // Check if remember me
        if ($this->expiresAt !== null) {
            // check if expired
            if ($this->expiresAt <= new \DateTimeImmutable()) {
                return 1;
            }
        }
        //check if address same
        if ($this->userAddress !== $userAddress) {
            return 2;
        }
        return 0;
    }

    /**
     * Validates expiration date of the token.
     *
     * @return bool True if date is future or null, false otherwise
     */
    public function isExpiresAtValid(): bool
    {
        if ($this->expiresAt === null) {
            return true;
        }

        return $this->expiresAt > new \DateTimeImmutable();
    }

    public function getUserAddress(): ?string
    {
        return $this->userAddress;
    }

    public function setUserAddress(string $userAddress): static
    {
        $this->userAddress = $userAddress;

        return $this;
    }
}
