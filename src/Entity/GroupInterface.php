<?php

declare(strict_types = 1);

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * Interface GroupInterface
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Entity
 */
interface GroupInterface extends ResourceInterface
{
    /**
     * @return null|string
     */
    public function getCode(): ?string;
    
    
    /**
     * @param string $code
     */
    public function setCode(?string $code): void;
    
    /**
     * @return null|string
     */
    public function __toString(): string;
    
    /**
     * @return string
     */
    public function getName(): ?string;
    
    /**
     * @param string $name
     */
    public function setName(?string $name): void;
    
    /**
     * @return Collection|RightInterface[]
     */
    public function getRights(): Collection;
    
    /**
     * @param Collection|RightInterface[] $rights
     */
    public function setRights(Collection $rights): void;
    
    /**
     * @param RightInterface $right
     *
     * @return bool
     */
    public function addRight(RightInterface $right): bool;
    
    /**
     * @param RightInterface $right
     *
     * @return bool
     */
    public function removeRight(RightInterface $right): bool;
}