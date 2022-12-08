<?php

namespace App\Entity;

use App\Repository\PubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PubRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Pub
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]

    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\OneToMany(mappedBy: 'pub', targetEntity: Gig::class, orphanRemoval: true)]
    private Collection $gigs;

    #[ORM\ManyToOne(inversedBy: 'pubs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Manager $manager = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->gigs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }


    public function getGigs(): Collection
    {
        return $this->gigs;
    }

    public function addGig(Gig $gig): self
    {
        if (!$this->gigs->contains($gig)) {
            $this->gigs->add($gig);
            $gig->setPub($this);
        }

        return $this;
    }

    public function removeGig(Gig $gig): self
    {
        if ($this->gigs->removeElement($gig)) {
            // set the owning side to null (unless already changed)
            if ($gig->getPub() === $this) {
                $gig->setPub(null);
            }
        }

        return $this;
    }

    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setManager(?Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Methode qui sera appelée automatiquement par Doctrine avant l'enregistrement d'un pub
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(): void
    {
     $this->setCreatedAt(new \DateTimeImmutable());
    }
}
