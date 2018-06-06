<?php

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Sylius\Component\Core\Model\AdminUserInterface as BaseAdminUserInterface;

interface AdminUserInterface extends BaseAdminUserInterface
{
    public function getGroup(): ?Group;

    public function setGroup(?Group $group): void;
}