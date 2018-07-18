<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Sylius\Component\Core\Model\AdminUser as BaseAdminUser;

/**
 * Class AdminUser
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Entity
 */
class AdminUser extends BaseAdminUser implements AdminUserInterface
{
    /** @var GroupInterface|null */
    protected $group = null;

    /**
     * @return GroupInterface|null
     */
    public function getGroup(): ?GroupInterface
    {
        return $this->group;
    }

    /**
     * @param GroupInterface|null $group
     */
    public function setGroup(?GroupInterface $group): void
    {
        $this->group = $group;
    }
}