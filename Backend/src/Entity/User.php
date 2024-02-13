<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\ExistsFilter;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\State\PasswordHasher;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Serializer\Filter\PropertyFilter;

use ApiPlatform\Metadata\ApiFilter;

use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(processor: PasswordHasher::class, validationContext: ['groups' => ['Default', 'user:create']]),
      //  new Get(),
      //  new Put(processor: PasswordHasher::class),
       // new Patch(processor: PasswordHasher::class),
        new Delete(),
    ],
    normalizationContext: [
        'groups' => ['user:read'],
    ],
    denormalizationContext: [
        'groups' => ['user:write'],
    ],
    paginationItemsPerPage: 25
    
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('nickname')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['nickname'], message: 'There is already an account with this nickname')]
#[UniqueEntity(fields: ['login'], message: 'There is already an account with this login')]

#[ApiFilter(OrderFilter::class, properties: ['id', 'nickname', 'createdAt'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'nickname' => 'ipartial'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
#[ApiFilter(PropertyFilter::class)]
#[ApiFilter(ExistsFilter::class, properties: ['ownedCommunities'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    #[ORM\Column(length: 50, unique: true)]
    private ?string $nickname = null;

    #[ORM\Column(nullable:true)]
    private array $roles = [];

    //DEBUG ONLY:
    //#[Groups(['user:read', 'user:write'])]
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['user:read', 'user:write'])]
    #[ORM\Column(length: 200, unique: true)]
    private ?string $email = null;

    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    #[ORM\Column(length: 50)]
    private ?string $login = null;

    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:write'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[Groups(['user:read'])]
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $createdAt;

    //#[MaxDepth(2)]
    #[ORM\OneToMany(targetEntity: Community::class, mappedBy: 'owner', orphanRemoval: false)]
    #[Groups(['user:read', 'user:write'])]
    private Collection $ownedCommunities;

    #[Assert\NotBlank(groups: ['user:write'])]
    #[Groups(['user:write'])]
    private ?string $plainPassword = null;

    #[Groups(['user:read', 'user:write'])]
    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Membership::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $joinedCommunities;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        // guarantee every user at least has ROLE_USER
        $this->roles[] = 'ROLE_USER';
        $this->ownedCommunities = new ArrayCollection();
        $this->joinedCommunities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->nickname;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return Collection<int, Community>
     */
    public function getOwnedCommunities(): Collection
    {
        return $this->ownedCommunities;
    }

    public function addOwnedCommunity(Community $ownedCommunity): static
    {
        if (!$this->ownedCommunities->contains($ownedCommunity)) {
            $this->ownedCommunities->add($ownedCommunity);
            $ownedCommunity->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedCommunity(Community $ownedCommunity): static
    {
        if ($this->ownedCommunities->removeElement($ownedCommunity)) {
            // set the owning side to null (unless already changed)
            if ($ownedCommunity->getOwner() === $this) {
                $ownedCommunity->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Membership>
     */
    public function getJoinedCommunities(): Collection
    {
        return $this->joinedCommunities;
    }

    public function addJoinedCommunity(Membership $joinedCommunity): static
    {
        if (!$this->joinedCommunities->contains($joinedCommunity)) {
            $this->joinedCommunities->add($joinedCommunity);
            $joinedCommunity->setMember($this);
        }

        return $this;
    }

    public function removeJoinedCommunity(Membership $joinedCommunity): static
    {
        if ($this->joinedCommunities->removeElement($joinedCommunity)) {
            // set the owning side to null (unless already changed)
            if ($joinedCommunity->getMember() === $this) {
                $joinedCommunity->setMember(null);
            }
        }

        return $this;
    }
}
