<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $genreName = null;

    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'classified')]
    private Collection $classify;

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
        $this->classify = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenreName(): ?string
    {
        return $this->genreName;
    }

    public function setGenreName(string $genreName): static
    {
        $this->genreName = $genreName;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getClassify(): Collection
    {
        return $this->classify;
    }

    public function addClassify(Livre $classify): static
    {
        if (!$this->classify->contains($classify)) {
            $this->classify->add($classify);
        }

        return $this;
    }

    public function removeClassify(Livre $classify): static
    {
        $this->classify->removeElement($classify);

        return $this;
    }
}
