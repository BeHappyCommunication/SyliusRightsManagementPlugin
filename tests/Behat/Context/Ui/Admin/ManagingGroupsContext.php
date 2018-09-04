<?php

declare(strict_types = 1);

namespace Tests\BeHappy\SyliusRightsManagementPlugin\Behat\Context\Ui\Admin;

use Tests\BeHappy\SyliusRightsManagementPlugin\Behat\Page\Admin\Group\CreatePageInterface;
use Tests\BeHappy\SyliusRightsManagementPlugin\Behat\Page\Admin\Group\IndexPageInterface;
use Tests\BeHappy\SyliusRightsManagementPlugin\Behat\Page\Admin\Group\UpdatePageInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingGroupsContext implements Context
{
    /** @var IndexPageInterface */
    private $indexPage;
    /** @var CreatePageInterface */
    private $createPage;
    /** @var UpdatePageInterface */
    private $updatePage;
    
    /**
     * ManagingGroupsContext constructor.
     *
     * @param IndexPageInterface  $indexPage
     * @param CreatePageInterface $createPage
     * @param UpdatePageInterface $updatePage
     */
    public function __construct(IndexPageInterface $indexPage, CreatePageInterface $createPage, UpdatePageInterface $updatePage)
    {
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
    }
    
    /**
     * @Given I want to add a new group
     *
     * @throws \Sylius\Behat\Page\UnexpectedPageException
     */
    public function iWantToAddNewGroup(): void
    {
        $this->createPage->open();
    }
    
    /**
     * @When I specify its name as :groupName
     *
     * @param string $groupName
     */
    public function iSpecifyItsNameAs(string $groupName): void
    {
        $this->createPage->specifyName($groupName);
    }
    
    /**
     * @When I specify its code as :code
     *
     * @param string $code
     */
    public function iSpecifyItsCodeAs(string $code): void
    {
        $this->createPage->specifyCode($code);
    }
    
    /**
     * @When I add it
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }
    
    /**
     * @Then the group :groupName should appear in the store
     *
     * @param string $groupName
     *
     * @throws \Sylius\Behat\Page\UnexpectedPageException
     */
    public function groupShouldAppearInTheStore(string $groupName): void
    {
        $this->indexPage->open();
        
        Assert::true(
            $this->indexPage->isSingleResourceOnPage(['name' => $groupName]),
            sprintf('Group %s should exist but it does not', $groupName)
        );
    }
}