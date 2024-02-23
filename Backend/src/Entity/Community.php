<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\CommunityRepository;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\State\CommunityStateProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommunityRepository::class)]
#[ApiResource(
    description: "Represents a group of users, containing posts from given topics.",
    shortName: "Subreddit",
    operations: [
        new Get,
        new GetCollection(
            normalizationContext: ['groups' => ['subreddit:read_list']]
        ),
        new Post(
            processor: CommunityStateProcessor::class,
            denormalizationContext: ['groups' => ['subreddit:create']],
            security: "is_authenticated()",
            securityMessage: "Only logged-in users can create a subreddit.",
        ),
        new Patch(
            processor: CommunityStateProcessor::class,
            security: "is_granted('ROLE_REDDIT_ADMIN') or object.getCreator() == user",
            securityMessage: "Only owner of the subreddit can modify it.",
        ),
        new Delete(
            security: "is_granted('ROLE_REDDIT_ADMIN') or object.getCreator() == user",
            securityMessage: "Only owner of the subreddit can delete it.",
        ),
    ],
    normalizationContext: [
        'groups' => ['subreddit:read'],
    ],
    denormalizationContext: [
        'groups' => ['subreddit:write'],
    ],
    paginationItemsPerPage: 25,
)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'name'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
#[UniqueEntity(fields: ['name'], message: 'There is already a subreddit with this name')]
class Community
{
    /**
     * Constants representing statuses for subreddits:
     * - STATUS_SUBRE_PUBLIC: Anyone can view, post, and comment to this subreddit.
     */
    const STATUS_SUBRE_PUBLIC = 'public';

    /**
     * STATUS_SUBRE_PRIVATE: Anyone can view, but only approved users can contribute.
     */
    const STATUS_SUBRE_PRIVATE = 'private';

    /**
     * STATUS_SUBRE_RESTRICTED: Only approved users can view and submit to this subreddit.
     */
    const STATUS_SUBRE_RESTRICTED = 'restricted';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 21, maxMessage: 'Subreddit name should be between 3 and 21 characters long')]
    #[Groups(['subreddit:read', 'subreddit:read_list', 'subreddit:write', 'subreddit:create', 'post:read'])]
    #[ORM\Column(length: 21, unique: true)]
    private ?string $name = null;

    #[Assert\Length(min: 0, max: 500, maxMessage: 'Subreddit description should be between 0 and 500 characters long')]
    #[Groups(['subreddit:read', 'subreddit:read_list', 'subreddit:create', 'subreddit:write', 'post:read'])]
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ApiProperty(
        security: 'is_granted("ROLE_REDDIT_ADMIN") or is_granted("SUBRE_VIEW", object)',
    )]
    #[Assert\Regex(
        pattern: '/^(public|restricted|private)$/',
        message: 'The status of a subreddit must be "public", "restricted", or "private".'
    )]
    #[Groups(['subreddit:read', 'subreddit:write', 'subreddit:create'])]
    #[ORM\Column(length: 10)]
    private ?string $status = self::STATUS_SUBRE_PUBLIC;

    #[ApiProperty(
        security: 'is_granted("ROLE_REDDIT_ADMIN") or is_granted("SUBRE_VIEW", object)',
    )]
    #[Groups(['subreddit:read', 'subreddit:write', 'subreddit:create'])]
    #[ORM\Column]
    private ?bool $sendWelcomeMessage = false;

    #[ApiProperty(
        security: 'is_granted("ROLE_REDDIT_ADMIN") or is_granted("SUBRE_VIEW", object)',
    )]
    #[Groups(['subreddit:read', 'subreddit:write', 'subreddit:create'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $welcomeMessageText = null;

    #[Groups(['subreddit:read', 'subreddit:read_list', 'subreddit:create', 'subreddit:write', 'post:read'])]
    #[ORM\Column]
    private ?bool $isNSFW = false;

    #[ApiProperty(
        security: 'is_granted("ROLE_REDDIT_ADMIN") or is_granted("SUBRE_VIEW", object)',
    )]
    #[Groups(['subreddit:read', 'subreddit:read_list'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt;

    #[ApiProperty(
        security: 'is_granted("ROLE_REDDIT_ADMIN") or is_granted("SUBRE_VIEW", object)',
    )]
    #[Groups(['subreddit:read', 'subreddit:read_list'])]
    #[ORM\ManyToOne(inversedBy: 'createdSubreddits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\OneToMany(mappedBy: 'subreddit', targetEntity: Membership::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $members;

    #[ORM\OneToMany(mappedBy: 'subreddit', targetEntity: Thread::class, orphanRemoval: true)]
    private Collection $posts;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->members = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return int current number of users that are members of this community
     */
    #[Groups(['subreddit:read', 'subreddit:read_list'])]
    public function getTotalMembers(): ?int
    {
        return $this->members->count();
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string public|private|restricted
     */
    public function setStatus(string $status): static
    {
        $allowedStatuses = [self::STATUS_SUBRE_PRIVATE, self::STATUS_SUBRE_PUBLIC, self::STATUS_SUBRE_RESTRICTED];

        if (!in_array($status, $allowedStatuses)) {
            throw new \InvalidArgumentException("Invalid status provided: $status, accepted values are: " . implode(", ", $allowedStatuses));
        }

        $this->status = $status;

        return $this;
    }

    public function isSendWelcomeMessage(): ?bool
    {
        return $this->sendWelcomeMessage;
    }

    public function setSendWelcomeMessage(bool $sendWelcomeMessage): static
    {
        $this->sendWelcomeMessage = $sendWelcomeMessage;

        return $this;
    }

    public function getWelcomeMessageText(): ?string
    {
        return $this->welcomeMessageText;
    }

    public function setWelcomeMessageText(?string $welcomeMessageText): static
    {
        $this->welcomeMessageText = $welcomeMessageText;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;
        if ($creator !== null) {
            $membership = new Membership();
            $membership->setMember($creator);
            $membership->setSubreddit($this);
            $this->members->add($membership);
        }

        return $this;
    }

    /**
     * @return Collection<int, Membership>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Membership $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setSubreddit($this);
        }
        return $this;
    }

    public function removeMember(Membership $member): static
    {
        if ($this->members->removeElement($member)) {
            if ($member->getSubreddit() === $this) {
                $member->setSubreddit(null);
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
            $post->setSubreddit($this);
        }

        return $this;
    }

    public function removePost(Thread $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getSubreddit() === $this) {
                $post->setSubreddit(null);
            }
        }

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