<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Group
 * @package BeHappy\RightsManagementPlugin\Entity
 */
class Group implements GroupInterface
{
    /** @var int */
    protected $id;
    /** @var string|null */
    protected $name;
    /** @var Collection */
    protected $rights = null;
    /** @var string|null */
    protected $code;

    /**
     * @return null|string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }


    /**
     * @param string $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

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
    public function __toString(): string
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
     * @return Collection|RightInterface[]
     */
    public function getRights(): Collection
    {
        return $this->rights;
    }

    /**
     * @param Collection|RightInterface[] $rights
     */
    public function setRights(Collection $rights): void
    {
        $this->rights = $rights;
    }
    
    /**
     * @param RightInterface $right
     *
     * @return bool
     */
    public function addRight(RightInterface $right): bool
    {
        if (!$this->getRights()->contains($right)) {
            $this->rights->add($right);
        }
        
        return true;
    }
    
    /**
     * @param RightInterface $right
     *
     * @return bool
     */
    public function removeRight(RightInterface $right): bool
    {
        return $this->rights->removeElement($right);
    }
}