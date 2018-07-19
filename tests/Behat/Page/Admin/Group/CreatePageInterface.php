<?php

declare(strict_types = 1);

namespace BeHappy\SyliusRightsManagementPlugin\Behat\Page\Admin\Group;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;

interface CreatePageInterface extends BaseCreatePageInterface
{
    public function chooseName(string $name): void;
}