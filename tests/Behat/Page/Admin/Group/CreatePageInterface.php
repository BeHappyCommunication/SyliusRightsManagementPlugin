<?php

declare(strict_types = 1);

namespace Tests\BeHappy\SyliusRightsManagementPlugin\Behat\Page\Admin\Group;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;

interface CreatePageInterface extends BaseCreatePageInterface
{
    public function specifyName(string $name): void;
    public function specifyCode(string $code): void;
}