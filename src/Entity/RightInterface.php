<?php

declare(strict_types = 1);

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * Interface RightInterface
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Entity
 */
interface RightInterface extends ResourceInterface
{
    /**
     * @return string
     */
    public function getRedirectTo(): string;
    
    /**
     * @param string $redirectTo
     */
    public function setRedirectTo(string $redirectTo): void;
    
    /**
     * @return string
     */
    public function getRedirectMessage(): string;
    
    /**
     * @param string $redirectMessage
     */
    public function setRedirectMessage(string $redirectMessage): void;
    
    /**
     * @return array|string[]
     */
    public function getRoutes(): array;
    
    /**
     * @param array|string[] $routes
     */
    public function setRoutes(array $routes): void;
    
    /**
     * @param string $route
     *
     * @return bool
     */
    public function addRoute(string $route): bool;
    
    /**
     * @param string $route
     *
     * @return bool
     */
    public function removeRoute(string $route): bool;
    
    /**
     * @return array
     */
    public function getExclude(): array;
    
    /**
     * @param array $exclude
     */
    public function setExclude(array $exclude): void;
    
    /**
     * @return bool
     */
    public function isGranted(): bool;
    
    /**
     * @param bool $granted
     */
    public function setGranted(bool $granted): void;
    
    /**
     * @return string
     */
    public function getName(): ?string;
    
    /**
     * @param string $name
     */
    public function setName(?string $name): void;
    
    /**
     * @return GroupInterface
     */
    public function getGroup(): GroupInterface;
    
    /**
     * @param GroupInterface $group
     */
    public function setGroup(GroupInterface $group): void;
}