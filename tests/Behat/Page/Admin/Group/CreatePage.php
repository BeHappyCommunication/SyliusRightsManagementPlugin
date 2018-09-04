<?php

declare(strict_types = 1);

namespace Tests\BeHappy\SyliusRightsManagementPlugin\Behat\Page\Admin\Group;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    /**
     * @param string $name
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function specifyName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }
    /**
     * @param string $code
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function specifyCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }
    
    public function create(): void
    {
        $this->getDocument()->pressButton('Create');
    }
}