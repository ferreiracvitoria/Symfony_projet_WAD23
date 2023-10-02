<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEdition = null;

    #[ORM\Column(length: 255)]
    private ?string $numberPages = null;

    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'owns')]
    private Collection $owner;

    #[ORM\ManyToMany(targetEntity: Genre::class, mappedBy: 'classify')]
    private Collection $classified;

    #[ORM\OneToMany(mappedBy: 'correspond', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'livresLus')]
    private Collection $lecteurs;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'livresRecommandes')]
    private Collection $recommandateurs;

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
        $this->owner = new ArrayCollection();
        $this->classified = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->lecteurs = new ArrayCollection();
        $this->recommandateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->dateEdition;
    }

    public function setDateEdition(\DateTimeInterface $dateEdition): static
    {
        $this->dateEdition = $dateEdition;

        return $this;
    }

    public function getNumberPages(): ?string
    {
        return $this->numberPages;
    }

    public function setNumberPages(string $numberPages): static
    {
        $this->numberPages = $numberPages;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getOwner(): Collection
    {
        return $this->owner;
    }

    public function addOwner(Author $owner): static
    {
        if (!$this->owner->contains($owner)) {
            $this->owner->add($owner);
            $owner->addOwn($this);
        }

        return $this;
    }

    public function removeOwner(Author $owner): static
    {
        if ($this->owner->removeElement($owner)) {
            $owner->removeOwn($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getClassified(): Collection
    {
        return $this->classified;
    }

    public function addClassified(Genre $classified): static
    {
        if (!$this->classified->contains($classified)) {
            $this->classified->add($classified);
            $classified->addClassify($this);
        }

        return $this;
    }

    public function removeClassified(Genre $classified): static
    {
        if ($this->classified->removeElement($classified)) {
            $classified->removeClassify($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setCorrespond($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getCorrespond() === $this) {
                $review->setCorrespond(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLecteurs(): Collection
    {
        return $this->lecteurs;
    }

    public function addLecteur(User $lecteur): static
    {
        if (!$this->lecteurs->contains($lecteur)) {
            $this->lecteurs->add($lecteur);
            $lecteur->addLivresLu($this);
        }

        return $this;
    }

    public function removeLecteur(User $lecteur): static
    {
        if ($this->lecteurs->removeElement($lecteur)) {
            $lecteur->removeLivresLu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRecommandateurs(): Collection
    {
        return $this->recommandateurs;
    }

    public function addRecommandateur(User $recommandateur): static
    {
        if (!$this->recommandateurs->contains($recommandateur)) {
            $this->recommandateurs->add($recommandateur);
            $recommandateur->addLivresRecommande($this);
        }

        return $this;
    }

    public function removeRecommandateur(User $recommandateur): static
    {
        if ($this->recommandateurs->removeElement($recommandateur)) {
            $recommandateur->removeLivresRecommande($this);
        }

        return $this;
    }
}
