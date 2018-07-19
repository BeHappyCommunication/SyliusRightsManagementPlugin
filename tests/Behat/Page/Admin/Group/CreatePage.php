<?php

declare(strict_types = 1);

namespace BeHappy\SyliusRightsManagementPlugin\Behat\Page\Admin\Group;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    /**
     * @param string $name
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function chooseName(string $name): void
    {
        $this->getDocument()->selectFieldOption('Name', $name);
    }
    
    public function create(): void
    {
        $this->getDocument()->pressButton('Create');
    }
}