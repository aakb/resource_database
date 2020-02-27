<?php

/*
 * This file is part of aakb/resource_database.
 *
 * (c) 2020 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_API')"},
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 * )
 *
 * @Gedmo\Loggable()
 *
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Gedmo\Versioned()
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Resource", inversedBy="locations")
     */
    private $resources;

    /**
     * Location constructor.
     */
    public function __construct()
    {
        $this->resources = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \App\Entity\Location
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|\App\Entity\Resource[]
     */
    public function getResources(): Collection
    {
        return $this->resources;
    }

    /**
     * @param \App\Entity\Resource $resource
     *
     * @return \App\Entity\Location
     */
    public function addResource(Resource $resource): self
    {
        if (!$this->resources->contains($resource)) {
            $this->resources[] = $resource;
        }

        return $this;
    }

    /**
     * @param \App\Entity\Resource $resource
     *
     * @return \App\Entity\Location
     */
    public function removeResource(Resource $resource): self
    {
        if ($this->resources->contains($resource)) {
            $this->resources->removeElement($resource);
        }

        return $this;
    }
}
