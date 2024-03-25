<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\State\Persisters\UserPersistStateProcessor;
use App\State\Removers\UserRemoveStateProcessor;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\State\Persisters\PasswordHasher;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\SerializedName;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    description: "Represents a single user in the system.",
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['user:read_list']],
        ),
        new Get(),
        new Post(
            processor: PasswordHasher::class,
            validationContext: ['groups' => ['Default', 'user:create']],
            denormalizationContext: ['groups' => ['user:create']],
        ),
        new Patch( // for password and email
            name: 'credentials',
            uriTemplate: '/users/credentials',
            processor: UserPersistStateProcessor::class,
            validationContext: ['groups' => ['user:write_credentials']],
            denormalizationContext: ['groups' => ['user:write_credentials']],
            security: "is_granted('ROLE_REDDIT_ADMIN') or is_granted('ROLE_USER')",
            securityMessage: "Only user himself can modify his settings.",
        ),
        new Patch( // for all other settings
            name: 'settings',
            uriTemplate: '/users',
            security: "is_granted('ROLE_REDDIT_ADMIN') or is_granted('ROLE_USER')",
            securityMessage: "Only user himself can modify his settings.",
            validationContext: ['groups' => ['user:write']],
            processor: UserPersistStateProcessor::class,
        ),
        new Delete(
            uriTemplate: '/users',
            security: "is_granted('ROLE_REDDIT_ADMIN') or is_granted('ROLE_USER')",
            securityMessage: "Only user himself can remove his account.",
            processor: UserRemoveStateProcessor::class,
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => ['oldPassword' => ['type' => 'string']],
                                'examples' => ['oldPassword' => 'string'],
                            ],
                        ],
                    ],
                ],
            ],
        ),
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
#[UniqueEntity(fields: ['login'], message: 'There is already an account with this login')]
#[ApiFilter(OrderFilter::class, properties: ['id', 'nickname', 'createdAt'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['login' => 'partial'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 3,
        minMessage: 'Username must be at least 3 characters long',
        max: 20,
        maxMessage: 'Username must be at most 20 characters long'
    )]
    #[Groups(['user:read', 'user:read_list', 'user:create', 'subreddit:read'])]
    #[ORM\Column(length: 50)]
    private ?string $login = null;

    #[Assert\Length(
        max: 30,
        maxMessage: 'Display name must be at most 30 characters long',
    )]
    #[Groups(['user:read', 'user:read_list', 'user:write', 'subreddit:read'])]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nickname = null;

    #[Assert\Email(groups: ['user:write_credentials', 'user:create'])]
    #[Groups(['user:read', 'user:create', 'user:write_credentials'])]
    #[ORM\Column(length: 200, nullable: true)]
    private ?string $email = null;

    #[Groups(['user:read', 'user:read_list', 'user:write'])]
    #[ORM\Column(length: 200, nullable: true)]
    private ?string $description = null;

    /**
     * @var string The hashed password
     */
    #[Assert\NotBlank(groups: ['user:write_credentials'])]
    #[Groups(['user:write_credentials'])]
    #[SerializedName("oldPassword")]
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(groups: ['user:create'])]
    #[Groups(['user:write_credentials', 'user:create'])]
    #[Assert\Length(
        min: 8,
        minMessage: 'Password must be at least 8 characters long',
        groups: ['user:create']
    )]
    private ?string $plainPassword = null;

    #[Groups(['user:read', 'user:read_list', 'user:write'])]
    #[ORM\Column]
    private ?bool $isNSFW = false;

    #[ORM\Column(nullable: true)]
    private array $roles = [];

    #[Groups(['user:read'])]
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $createdAt;

    #[ORM\OneToMany(targetEntity: Community::class, mappedBy: 'creator', orphanRemoval: false)]
    private Collection $createdSubreddits;

    #[ApiProperty(
        security: 'is_granted("ROLE_REDDIT_ADMIN") or object == user',
    )]
    #[Groups(['user:read'])]
    #[ORM\OneToMany(
        mappedBy: 'member',
        targetEntity: Membership::class,
        orphanRemoval: true,
        cascade: ['persist']
    )]
    private Collection $joinedSubreddits;

    #[Groups(['user:read'])]
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Thread::class, cascade:["remove"])]
    private Collection $posts;

    #[Groups(['user:read'])]
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class, cascade:["remove"])]
    private Collection $comments;

    #[ApiProperty(
        security: 'is_granted("ROLE_REDDIT_ADMIN") or object == user',
    )]
    #[Groups(['user:read'])]
    #[ORM\OneToMany(mappedBy: 'ownedBy', targetEntity: AccessToken::class, orphanRemoval: true)]
    private Collection $accessTokens;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->createdSubreddits = new ArrayCollection();
        $this->joinedSubreddits = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->accessTokens = new ArrayCollection();

        // guarantee every user at least has ROLE_USER
        $this->roles[] = 'ROLE_USER';
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
        return (string) $this->login;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Returns the difference in seconds between the creation date and now.
     *
     * @return int The difference in seconds
     */
    #[Groups(['user:read'])]
    public function getCreatedAtInSeconds(): ?int
    {
        $now = new \DateTime();
        return($now->getTimestamp() - $this->createdAt->getTimestamp());
    }

    /**
     * @return Collection<int, Community>
     */
    public function getCreatedSubreddits(): Collection
    {
        return $this->createdSubreddits;
    }

    public function addCreatedSubreddit(Community $createdSubreddit): static
    {
        if (!$this->createdSubreddits->contains($createdSubreddit)) {
            $this->createdSubreddits->add($createdSubreddit);
            $createdSubreddit->setCreator($this);
        }

        return $this;
    }

    public function removeCreatedSubreddit(Community $createdSubreddit): static
    {
        if ($this->createdSubreddits->removeElement($createdSubreddit)) {
            // set the owning side to null (unless already changed)
            if ($createdSubreddit->getCreator() === $this) {
                $createdSubreddit->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Membership>
     */
    public function getJoinedSubreddits(): Collection
    {
        return $this->joinedSubreddits;
    }

    public function addJoinedSubreddit(Membership $joinedSubreddit): static
    {
        if (!$this->joinedSubreddits->contains($joinedSubreddit)) {
            $this->joinedSubreddits->add($joinedSubreddit);
            $joinedSubreddit->setMember($this);
        }

        return $this;
    }

    public function removeJoinedSubreddit(Membership $joinedSubreddit): static
    {
        if ($this->joinedSubreddits->removeElement($joinedSubreddit)) {
            // set the owning side to null (unless already changed)
            if ($joinedSubreddit->getMember() === $this) {
                $joinedSubreddit->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Thread>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Thread $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Thread $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AccessToken>
     */
    public function getAccessTokens(): Collection
    {
        return $this->accessTokens;
    }

    public function addAccessToken(AccessToken $accessToken): static
    {
        if (!$this->accessTokens->contains($accessToken)) {
            $this->accessTokens->add($accessToken);
            $accessToken->setOwnedBy($this);
        }

        return $this;
    }

    public function removeAccessToken(AccessToken $accessToken): static
    {
        if ($this->accessTokens->removeElement($accessToken)) {
            // set the owning side to null (unless already changed)
            if ($accessToken->getOwnedBy() === $this) {
                $accessToken->setOwnedBy(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isIsNSFW(): ?bool
    {
        return $this->isNSFW;
    }

    public function setIsNSFW(bool $isNSFW): static
    {
        $this->isNSFW = $isNSFW;

        return $this;
    }
}
