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
use Carbon\Carbon;
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
    description: "A community of users containing posts from given theme.",
    //shortName: "Comm",
    operations: [
        // new Get,
        new GetCollection,
        new Post,
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
#[ApiFilter(OrderFilter::class, properties: ['id', 'name', 'numberOfUsers'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'status' => 'exact', 'name' => 'ipartial', 'desciption' => 'ipartial'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
#[ApiFilter(RangeFilter::class, properties: ['numberOfUsers'])]
#[ApiFilter(PropertyFilter::class)]
#[UniqueEntity(fields: ['name'], message: 'There is already a community with this name')]
class Community
{
    const STATUS_PUBLIC = 'public';
    const STATUS_PRIVATE = 'private';
    const STATUS_RESTRICTED = 'restricted';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 100, maxMessage: 'Community name should be between 3 and 100 characters long')]
    #[Groups(['community:read', 'community:write'])]
    #[ORM\Column(length: 100, unique: true)]
    private ?string $name = null;

    #[Assert\Length(min: 0, max: 500, maxMessage: 'Community description should be between 0 and 500 characters long')]
    #[Groups(['community:read', 'community:write'])]
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

   // #[Assert\PositiveOrZero]
    #[Groups(['community:read'])]
    #[ORM\Column]
    private ?int $numberOfUsers = 0;

    #[Groups(['community:read'])]
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $createdAt;

    #[Assert\Regex(
        pattern: '/^(public|restricted|private)$/',
        message: 'The status must be "public", "restricted", or "private".'
    )]
    #[Groups(['community:read', 'community:write'])]
    #[ORM\Column(length: 10)]
    private ?string $status = self::STATUS_PUBLIC;

    #[Groups(['community:read', 'community:write'])]
    #[ORM\Column]
    private ?bool $sendWelcomeMessage = false;

    #[Groups(['community:read', 'community:write'])]
    #[ORM\ManyToOne(inversedBy: 'ownedCommunities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;
    
    #[Groups(['community:read', 'community:write'])]
    #[ORM\OneToMany(mappedBy: 'community', targetEntity: Membership::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $members;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->members = new ArrayCollection();
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

    public function getNumberOfUsers(): ?int
    {
        return $this->numberOfUsers;
    }

    /**
     * Increases the number of users associated with this community.
     *
     * @return int The updated number of users after incrementing.
     */
    public function increaseNumberOfUsers(): int
    {
        $this->numberOfUsers++;
        return $this->numberOfUsers;
    }

    /**
     * Decreases the number of users associated with this community.
     *
     * @return int The updated number of users after decrementing.
     */
    public function decreaseNumberOfUsers(): int
    {
        $this->numberOfUsers--;
        return $this->numberOfUsers;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return string of human-readable information when comunity was created
     */
    #[Groups(['community:read'])]
    public function getCreatedAtAgo(): ?string
    {
        return Carbon::instance($this->createdAt)->diffForHumans();
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
        $allowedStatuses = [self::STATUS_PRIVATE, self::STATUS_PUBLIC, self::STATUS_RESTRICTED];

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        if ($owner !== null && !$this->members->contains($owner)) {
            $membership = new Membership();
            $membership->setMember($owner);
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

        // Increase number of users
        $this->increaseNumberOfUsers();
        return $this;
    }

    public function removeMember(Membership $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getCommunity() === $this) {
                $member->setCommunity(null);
            }
        }
        // Increase number of users
        $this->decreaseNumberOfUsers();
        return $this;
    }
}
