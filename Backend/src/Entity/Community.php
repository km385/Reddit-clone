<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use App\Repository\CommunityRepository;
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
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommunityRepository::class)]
#[ApiResource(
    description: "Represents a community of users, containing posts from given topics.",
    //TODO: replace with sub reddit 
    shortName: "Reddit",
    operations: [
        // new Get,
        new GetCollection,
        new Post(
            denormalizationContext: ['groups' => ['community:create']]
        ),
        // new Patch,
        new Delete,
        // new Put,
    ],
    normalizationContext: [
        'groups' => ['community:read'],
    ],
    denormalizationContext: [
        'groups' => ['community:write'],
    ],
    paginationItemsPerPage: 25,
)]
//TODO: Make custom filter for status
#[ApiFilter(OrderFilter::class, properties: ['id', 'name', 'numberOfUsers'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'status' => 'exact', 'name' => 'ipartial', 'desciption' => 'ipartial'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
#[ApiFilter(RangeFilter::class, properties: ['numberOfUsers'])]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(fields: ['name'], message: 'There is already a community with this name')]
class Community
{
    /**
     * Constants representing statuses for communities:
     * - STATUS_COMMU_PUBLIC: Anyone can view, post, and comment to this community.
     */
    const STATUS_COMMU_PUBLIC = 'public';

    /**
     * STATUS_COMMU_PRIVATE: Anyone can view, but only approved users can contribute.
     */
    const STATUS_COMMU_PRIVATE = 'private';

    /**
     * STATUS_COMMU_RESTRICTED: Only approved users can view and submit to this community.
     */
    const STATUS_COMMU_RESTRICTED = 'restricted';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 21, maxMessage: 'Community name should be between 3 and 21 characters long')]
    #[Groups(['community:read', 'community:write', 'community:create', 'post:read'])]
    #[ORM\Column(length: 21, unique: true)]
    private ?string $name = null;

    #[Assert\Length(min: 0, max: 500, maxMessage: 'Community description should be between 0 and 500 characters long')]
    #[Groups(['community:read', 'community:write', 'community:create'])]
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[Groups(['community:read'])]
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $createdAt;

    #[Assert\Regex(
        pattern: '/^(public|restricted|private)$/',
        message: 'The status must be "public", "restricted", or "private".'
    )]
    #[Groups(['community:read', 'community:write', 'community:create', 'post:read'])]
    #[ORM\Column(length: 10)]
    private ?string $status = self::STATUS_COMMU_PUBLIC;

    //TODO: add string messege body 
    #[Groups(['community:read', 'community:write', 'community:create'])]
    #[ORM\Column]
    private ?bool $sendWelcomeMessage = false;

    #[Groups(['community:read', 'community:write', 'community:create'])]
    #[ORM\ManyToOne(inversedBy: 'createdCommunities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[Groups(['community:read', 'community:write'])]
    #[ORM\OneToMany(mappedBy: 'community', targetEntity: Membership::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $members;

    #[Groups(['community:read', 'community:write'])]
    #[ORM\OneToMany(mappedBy: 'community', targetEntity: Thread::class, orphanRemoval: true)]
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

    #[Groups(['community:read'])]
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return int current number of users that are members of this community
     */
    #[Groups(['community:read'])]
    public function getTotalMembers(): ?int
    {
        return $this->members->count();
        ;
    }

    // /**
    //  * @return string of human-readable information when comunity was created
    //  */
    // #[Groups(['community:read'])]
    // public function getCreatedAtAgo(): ?string
    // {
    //     return Carbon::instance($this->createdAt)->diffForHumans();
    // }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string public|private|restricted
     */
    public function setStatus(string $status): static
    {
        $allowedStatuses = [self::STATUS_COMMU_PRIVATE, self::STATUS_COMMU_PUBLIC, self::STATUS_COMMU_RESTRICTED];

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
            $membership->setCommunity($this);
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
            $member->setCommunity($this);
        }
        return $this;
    }

    public function removeMember(Membership $member): static
    {
        if ($this->members->removeElement($member)) {
            if ($member->getCommunity() === $this) {
                $member->setCommunity(null);
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
            $post->setCommunity($this);
        }

        return $this;
    }

    public function removePost(Thread $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCommunity() === $this) {
                $post->setCommunity(null);
            }
        }

        return $this;
    }
}
