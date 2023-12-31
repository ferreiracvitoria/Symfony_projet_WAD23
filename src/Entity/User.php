<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Review::class)]
    private Collection $ecrit;

    #[JoinTable(name: 'lectures')]
    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'lecteurs')]
    private Collection $livresLus;

    #[JoinTable(name: 'recommendations')]
    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'recommandateurs')]
    private Collection $livresRecommandes;

    // constructeur et hydrate
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
        $this->ecrit = new ArrayCollection();
        $this->livresLus = new ArrayCollection();
        $this->livresRecommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getEcrit(): Collection
    {
        return $this->ecrit;
    }

    public function addEcrit(Review $ecrit): static
    {
        if (!$this->ecrit->contains($ecrit)) {
            $this->ecrit->add($ecrit);
            $ecrit->setUsers($this);
        }

        return $this;
    }

    public function removeEcrit(Review $ecrit): static
    {
        if ($this->ecrit->removeElement($ecrit)) {
            // set the owning side to null (unless already changed)
            if ($ecrit->getUsers() === $this) {
                $ecrit->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivresLus(): Collection
    {
        return $this->livresLus;
    }

    public function addLivresLu(Livre $livresLu): static
    {
        if (!$this->livresLus->contains($livresLu)) {
            $this->livresLus->add($livresLu);
        }

        return $this;
    }

    public function removeLivresLu(Livre $livresLu): static
    {
        $this->livresLus->removeElement($livresLu);

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivresRecommandes(): Collection
    {
        return $this->livresRecommandes;
    }

    public function addLivresRecommande(Livre $livresRecommande): static
    {
        if (!$this->livresRecommandes->contains($livresRecommande)) {
            $this->livresRecommandes->add($livresRecommande);
        }

        return $this;
    }

    public function removeLivresRecommande(Livre $livresRecommande): static
    {
        $this->livresRecommandes->removeElement($livresRecommande);

        return $this;
    }
}
