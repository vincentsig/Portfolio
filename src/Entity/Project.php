<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\ProjectRepository;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id = null;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private ?string $name = null;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;


    /**
     * @var string|null
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private ?string $slug = null;

    /**
     * @var Media
     * @Assert\NotBlank
     * @ORM\OneToOne(targetEntity=Media::class, cascade={"persist", "remove"})
     */
    private $media;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $createdAt = null;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlGithub;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlWebsite;

    /**
     * @Assert\NotBlank
     * @ORM\ManyToMany(targetEntity=Techno::class, inversedBy="project")
     */
    private $technos;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime('now'));
        $this->technos = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Media
     */
    public function getMedia(): ?Media
    {
        return $this->media;
    }

    /**
     * @param Media
     */
    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     *
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     *
     * @param null|string $content
     * @return Project
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     *
     * @return null|string
     */
    public function getUrlGithub(): ?string
    {
        return $this->urlGithub;
    }

    /**
     *
     * @param null|string $urlGithub
     * @return Project
     */
    public function setUrlGithub(?string $urlGithub): self
    {
        $this->urlGithub = $urlGithub;

        return $this;
    }

    /**
     *
     * @return null|string
     */
    public function getUrlWebsite(): ?string
    {
        return $this->urlWebsite;
    }

    /**
     *
     * @param null|string $urlWebsite
     * @return Project
     */
    public function setUrlWebsite(?string $urlWebsite): self
    {
        $this->urlWebsite = $urlWebsite;

        return $this;
    }

    /**
     * @return Collection|techno[]
     */
    public function getTechnos(): Collection
    {
        return $this->technos;
    }

    /**
     *
     * @param Techno $techno
     * @return Project
     */
    public function addTechno(techno $techno): self
    {
        if (!$this->technos->contains($techno)) {
            $this->technos[] = $techno;
            $techno->setProject($this);
        }

        return $this;
    }

    /**
     *
     * @param Techno $techno
     * @return Project
     */
    public function removeTechno(techno $techno): self
    {
        if ($this->technos->removeElement($techno)) {
            // set the owning side to null (unless already changed)
            if ($techno->getProject() === $this) {
                $techno->setProject(null);
            }
        }

        return $this;
    }
}
