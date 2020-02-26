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
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 * )
 *
 * @Gedmo\Loggable()
 *
 * @ORM\Entity(repositoryClass="App\Repository\ResourceRepository")
 */
class Resource extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Gedmo\Versioned()
     */
    private $name;

    /**
     * @ORM\Column(type="ResourceType")
     *
     * @Gedmo\Versioned()
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Gedmo\Versioned()
     */
    private $exchangeId;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location", mappedBy="resources")
     */
    private $locations;

    /**
     * Resource constructor.
     */
    public function __construct()
    {
        $this->locations = new ArrayCollection();
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
     * @return \App\Entity\Resource
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     *
     * @return \App\Entity\Resource
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExchangeId(): ?string
    {
        return $this->exchangeId;
    }

    /**
     * @param string|null $exchangeId
     *
     * @return \App\Entity\Resource
     */
    public function setExchangeId(?string $exchangeId): self
    {
        $this->exchangeId = $exchangeId;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    /**
     * @param \App\Entity\Location $location
     *
     * @return \App\Entity\Resource
     */
    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->addResource($this);
        }

        return $this;
    }

    /**
     * @param \App\Entity\Location $location
     *
     * @return \App\Entity\Resource
     */
    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            $location->removeResource($this);
        }

        return $this;
    }
}
