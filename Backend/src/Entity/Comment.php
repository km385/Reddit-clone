<?php

namespace App\Entity;


use App\Repository\CommentRepository;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Serializer\Filter\PropertyFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource(
    description: "Represents a single messege send by a users, inside given post.",
    //shortName: "Comme",
    operations: [
        // new Get,
        new GetCollection,
        new Post(
            denormalizationContext: ['groups' => ['comment:create']]
        ),
        // new Patch,
        new Delete,
        // new Put,
    ],
    normalizationContext: [
        'groups' => ['comment:read'],
    ],
    denormalizationContext: [
        'groups' => ['comment:write'],
    ],
    paginationItemsPerPage: 25,
)]

#[ApiFilter(OrderFilter::class, properties: ['id', 'createdAt'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'author.id' => 'exact',
    'post.id' => 'exact'
])]
#[ApiFilter(DateFilter::class, properties: ['createdAt', 'modifiedAt'])]

class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 5500, maxMessage: 'Comment should be between 3 and 5500 characters long')]
    #[Groups(['comment:read', 'comment:write', 'comment:create', 'post:read','user:read'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(['comment:read', 'comment:write', 'post:read'])]
    #[ORM\Column]
    private ?bool $isSticky = false;

    #[Groups(['comment:read', 'comment:write', 'post:read'])]
    #[ORM\Column]
    private ?bool $isLocked = false;

    #[Groups(['comment:read', 'comment:write', 'post:read'])]
    #[ORM\Column]
    private ?bool $isApproved = false;

    #[Groups(['comment:read', 'comment:write', 'post:read'])]
    #[ORM\Column]
    private ?bool $isMod = false;

    //TODO: do author remove
    // Delete for moderators, when delted by author should be done by hand in method with no flag
    #[Groups(['comment:read', 'comment:write', 'post:read'])]
    #[ORM\Column]
    private ?bool $isDeleted = false;

    #[Groups(['comment:read', 'post:read','user:read'])]
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    //TODO: by hand modify when edited content by author
    #[Groups(['comment:read', 'post:read','user:read'])]
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifiedAt = null;

    #[Groups(['comment:write'])]
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childComments')]
    private ?self $parentComment = null;

    #[Groups(['comment:read', 'post:read','user:read'])]
    #[ORM\OneToMany(mappedBy: 'parentComment', targetEntity: self::class, orphanRemoval: true)]
    #[MaxDepth(2)]
    //TODO: find solution for depth not working for same calss objects
    private Collection $childComments;

    #[Groups(['comment:read','comment:create','post:read'])]
    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?User $author = null;

    #[Groups(['user:read','comment:create'])]
    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Thread $post = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->childComments = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function isIsSticky(): ?bool
    {
        return $this->isSticky;
    }

    public function setIsSticky(bool $isSticky): static
    {
        $this->isSticky = $isSticky;

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

    public function isIsApproved(): ?bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): static
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    public function isIsMod(): ?bool
    {
        return $this->isMod;
    }

    public function setIsMod(bool $isMod): static
    {
        $this->isMod = $isMod;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getParentComment(): ?self
    {
        return $this->parentComment;
    }

    public function setParentComment(?self $parentComment): static
    {
        $this->parentComment = $parentComment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildComments(): Collection
    {
        return $this->childComments;
    }

    public function addChildComment(self $childComment): static
    {
        if (!$this->childComments->contains($childComment)) {
            $this->childComments->add($childComment);
            $childComment->setParentComment($this);
        }

        return $this;
    }

    public function removeChildComment(self $childComment): static
    {
        if ($this->childComments->removeElement($childComment)) {
            // set the owning side to null (unless already changed)
            if ($childComment->getParentComment() === $this) {
                $childComment->setParentComment(null);
            }
        }

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

    public function setModifiedAt(?\DateTimeInterface $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
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

    public function getPost(): ?Thread
    {
        return $this->post;
    }

    public function setPost(?Thread $post): static
    {
        $this->post = $post;

        return $this;
    }
}
