<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MembershipRepository;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use App\State\Persisters\MembershipPersistStateProcessor;
use App\State\Removers\MembershipRemoveStateProcessor;
use App\State\Providers\CommunityStateProvider;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipRepository::class)]
#[ApiResource(
    description: "A representation of a single user being a member of given subreddit.",
    operations: [
        new Post(
            uriTemplate: '/subreddits/{subreddit_id}/join.{_format}',
            uriVariables: [
                'subreddit_id' => new Link(
                    fromClass: Community::class,
                    fromProperty: 'members',
                ),
            ],
            security: "is_authenticated()",
            securityMessage: "Only logged-in users can join a subreddit.",
            denormalizationContext: ['groups' => ['membership:create']],
            openapiContext: ['requestBody' => false],
            deserialize: false,
            input: Community::class,
            provider: CommunityStateProvider::class,
            processor: MembershipPersistStateProcessor::class,
        ),
        new Delete(
            uriTemplate: '/subreddits/{subreddit_id}/leave.{_format}',
            uriVariables: [
                'subreddit_id' => new Link(
                    fromClass: Community::class,
                    fromProperty: 'members'
                ),
            ],
            security: "is_authenticated()",
            securityMessage: "Only logged-in users can leave a subreddit.",
            input: Community::class,
            provider: CommunityStateProvider::class,
            processor: MembershipRemoveStateProcessor::class,
        ),
    ],
)]
#[UniqueEntity(fields: ['subreddit', 'member'], message: "You are already member of this subreddit.")]
class Membership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $createdAt;

    #[ORM\ManyToOne(inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Community $subreddit = null;

    #[ORM\ManyToOne(inversedBy: 'joinedSubreddits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $member = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getCreatedAtInSeconds(): ?int
    {
        $now = new \DateTime();
        return ($now->getTimestamp() - $this->createdAt->getTimestamp());
    }

    public function getSubreddit(): ?Community
    {
        return $this->subreddit;
    }

    public function setSubreddit(?Community $subreddit): static
    {
        $this->subreddit = $subreddit;

        return $this;
    }

    public function getMember(): ?User
    {
        return $this->member;
    }

    public function setMember(?User $member): static
    {
        $this->member = $member;

        return $this;
    }
}
