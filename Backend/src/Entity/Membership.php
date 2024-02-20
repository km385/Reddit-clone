<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MembershipRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[UniqueEntity(fields: ['subreddit', 'member'], message: "You are already member of this subreddit.")]
#[ORM\Entity(repositoryClass: MembershipRepository::class)]
#[ApiResource(
    description: "A representation of a single user being a member of given subreddit.",
    operations: [
        new Get,
        //new GetCollection,
        new Post,
        new Delete,
    ],
)]
class Membership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $createdAt;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Community $subreddit = null;

    #[Assert\NotBlank]
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
