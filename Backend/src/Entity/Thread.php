<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Serializer\Filter\PropertyFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiFilter;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
#[ApiResource(
    description: "Represents a single piece of content submitted by a given user to a given community.",
    shortName: "Post",
    operations: [
        // new Get,
        new GetCollection,
        new Post(
            denormalizationContext: ['groups' => ['post:create']]
        ),
        new Patch,
        new Delete,
        // new Put,
    ],
    normalizationContext: [
        'groups' => ['post:read'],
    ],
    denormalizationContext: [
        'groups' => ['post:write'],
    ],
    paginationItemsPerPage: 35,
)]


//TODO: By ammount of comments
//TODO: Make custom filter for status
//TODO: Stop Comments From Being Added in Locked Posts
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'status' => 'exact','title' => 'ipartial', 'content' => 'ipartial', 'community.name' => 'ipartial', 'community.id' => 'exact', 'author.id' => 'exact'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
#[ApiFilter(PropertyFilter::class)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'name', 'numberOfUsers'], arguments: ['orderParameterName' => 'order'])]

class Thread
{
    /**
     * Constants representing statuses for posts:
     * - STATUS_DELETED: Indicates that the post has been deleted by the user.
     */
    const STATUS_POST_DELETED = 'deleted';

    /**
     * STATUS_APPROVED: Indicates that the post has been approved and is visible.
     */
    const STATUS_POST_APPROVED = 'approved';

    /**
     * STATUS_PENDING_APPROVAL: Indicates that the post is awaiting moderation approval.
     */
    const STATUS_POST_PENDING_APPROVAL = 'pending_approval';

    /**
     * STATUS_REMOVED: Indicates that the post has been removed by moderation.
     */
    const STATUS_POST_REMOVED = 'removed';

    /**
     * Constants representing types of posts:
     * - TYPE_TEXT: Represents a post with text content.
     */
    const TYPE_POST_TEXT = 'text';

    /**
     * TYPE_IMAGE: Represents a post with image link content.
     */
    const TYPE_POST_IMAGE = 'image';

    /**
     * TYPE_LINK: Represents a post with a link to external content.
     */
    const TYPE_POST_LINK = 'link';

    /**
     * TYPE_REPOST: Represents a post with link to existing Post.
     */
    const TYPE_POST_REPOST = 'repost';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 300, maxMessage: 'Post title should be between 3 and 300 characters long')]
    #[Groups(['post:read', 'post:write', 'post:create'])]
    #[ORM\Column(length: 300)]
    private ?string $title = null;

    //TODO: Check value base on type of post
    #[Groups(['post:read', 'post:write', 'post:create'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    //TODO: Split check so mods can set deleted removed and approved pending approval is set automatically
    #[Assert\Regex(
        pattern: '/^(deleted|approved|pending_approval|removed)$/',
        message: 'The status must be "deleted", "approved", "pending_approval" or "removed".',
    )]
    #[Groups(['post:read', 'post:write'])]
    #[ORM\Column(length: 16)]
    private ?string $status = 'pending_approval';

    #[Assert\Regex(
        pattern: '/^(text|image|link|repost)$/',
        message: 'The type must be "text", "image", "link" or "repost".',
    )]
    #[Groups(['post:read', 'post:write', 'post:create'])]
    #[ORM\Column(length: 6)]
    private ?string $type = 'text';

    #[Groups(['post:read', 'post:write', 'post:create'])]
    #[ORM\Column]
    private ?bool $isNsfw = false;

    #[Groups(['post:read', 'post:write', 'post:create'])]
    #[ORM\Column]
    private ?bool $isSpoiler = false;

    #[Groups(['post:read', 'post:write'])]
    #[ORM\Column]
    private ?bool $isLocked = false;

    #[Groups(['post:read'])]
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $createdAt;

    #[Groups(['post:read'])]
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifiedAt = null;

    #[Assert\NotBlank(groups: ['create'])]
    #[Groups(['post:read', 'post:create'])]
    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $author = null;

    #[Assert\NotBlank]
    #[Groups(['post:read', 'post:create'])]
    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Community $community = null;

    //TODO: comments

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
    #[Groups(['post:create'])]
    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }
    #[Groups(['post:write'])]
    public function setContentModify(?string $content): static
    {
        $this->content = $content;
        $this->modifiedAt = new \DateTime();
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isIsNsfw(): ?bool
    {
        return $this->isNsfw;
    }

    public function setIsNsfw(bool $isNsfw): static
    {
        $this->isNsfw = $isNsfw;

        return $this;
    }

    public function isIsSpoiler(): ?bool
    {
        return $this->isSpoiler;
    }

    public function setIsSpoiler(bool $isSpoiler): static
    {
        $this->isSpoiler = $isSpoiler;

        return $this;
    }

    public function isIsLocked(): ?bool
    {
        return $this->isLocked;
    }

    public function setIsLocked(bool $isLocked): static
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCommunity(): ?Community
    {
        return $this->community;
    }
    public function setCommunity(?Community $community): static
    {
        //TODO: check if author is on authorized list
        $this->community = $community;
        //if community is private, set status to pending approval
        $this->status = ($this->community->getStatus() == Community::STATUS_COMMU_PRIVATE) ? self::STATUS_POST_PENDING_APPROVAL : self::STATUS_POST_APPROVED;
        return $this;
    }
}