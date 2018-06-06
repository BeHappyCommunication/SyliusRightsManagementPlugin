<?php

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Sylius\Component\Core\Model\AdminUser as BaseAdminUser;

class AdminUser extends BaseAdminUser implements AdminUserInterface
{
    /** @var Group|null */
    protected $group = null;

    /**
     * @return Group|null
     */
    public function getGroup(): ?Group
    {
        return $this->group;
    }

    /**
     * @param Group|null $group
     */
    public function setGroup(?Group $group): void
    {
        $this->group = $group;
    }
}