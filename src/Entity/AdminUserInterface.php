<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Sylius\Component\Core\Model\AdminUserInterface as BaseAdminUserInterface;

/**
 * Interface AdminUserInterface
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Entity
 */
interface AdminUserInterface extends BaseAdminUserInterface
{
    /**
     * @return GroupInterface|null
     */
    public function getGroup(): ?GroupInterface;
    
    /**
     * @param GroupInterface|null $group
     */
    public function setGroup(?GroupInterface $group): void;
}