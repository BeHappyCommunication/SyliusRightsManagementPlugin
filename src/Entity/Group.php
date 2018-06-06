<?php

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * Class Group
 * @package BeHappy\RightsManagementPlugin\Entity
 */
class Group implements ResourceInterface
{
    /** @var int */
    protected $id;
    /** @var string|null */
    protected $name;
    /** @var Collection */
    protected $rights = null;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->setRights(new ArrayCollection());
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection
     */
    public function getRights(): Collection
    {
        return $this->rights;
    }

    /**
     * @param Collection $rights
     */
    public function setRights(Collection $rights): void
    {
        $this->rights = $rights;
    }
}