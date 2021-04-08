<?php

namespace App\Entity;

use App\Repository\TechnoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TechnoRepository::class)
 */
class Techno
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="technos")
     */
    private $project;

    /**
     *
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     *
     * @param null|string $name
     * @return Techno
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @return null|string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     *
     * @param null|string $slug
     * @return Techno
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     *
     * @return null|Project
     */
    public function getProject(): ?Project
    {
        return $this->project;
    }

    /**
     *
     * @param null|Project $project
     * @return Techno
     */
    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
