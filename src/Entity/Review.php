<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateReview = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\ManyToOne(inversedBy: 'ecrit')]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?Livre $livres = null;

    public function hydrate (array $vals){
        foreach ($vals as $cle => $valeur){
            if (isset ($vals[$cle])){
                $nomSet = "set" . ucfirst($cle);
                $this->$nomSet ($valeur);
            }
        }
    }
    public function __construct(array $init =[])
    {
        $this->hydrate($init);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateReview(): ?\DateTimeInterface
    {
        return $this->dateReview;
    }

    public function setDateReview(\DateTimeInterface $dateReview): static
    {
        $this->dateReview = $dateReview;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getLivres(): ?Livre
    {
        return $this->livres;
    }

    public function setLivres(?Livre $livres): static
    {
        $this->livres = $livres;

        return $this;
    }
}
