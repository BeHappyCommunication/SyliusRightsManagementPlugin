<?php

declare(strict_types = 1);

namespace BeHappy\SyliusRightsManagementPlugin\Service;

use BeHappy\SyliusRightsManagementPlugin\Entity\AdminUserInterface;
use BeHappy\SyliusRightsManagementPlugin\Entity\GroupInterface;
use BeHappy\SyliusRightsManagementPlugin\Entity\RightInterface;

/**
 * Interface GroupServiceInterface
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Service
 */
interface GroupServiceInterface
{
    /**
     * Add missing rights to group entity.
     *
     * @param GroupInterface $group
     *
     * @throws \Exception
     */
    public function createMissingRights(GroupInterface &$group): void;
    
    /**
     * @param string             $route
     * @param AdminUserInterface $user
     *
     * @return bool
     */
    public function isUserGranted(string $route, AdminUserInterface $user): bool;
    
    /**
     * @param string             $route
     * @param AdminUserInterface $user
     *
     * @return RightInterface|null
     */
    public function getRight(string $route, AdminUserInterface $user): ?RightInterface;
    
    /**
     * @param RightInterface $right
     *
     * @return string
     */
    public function getRedirectRoute(?RightInterface $right): string;
    
    /**
     * @param RightInterface $right
     *
     * @return string
     */
    public function getRedirectMessage(?RightInterface $right): string;
}