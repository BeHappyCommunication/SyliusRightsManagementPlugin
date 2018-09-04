<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\Menu;

use BeHappy\SyliusRightsManagementPlugin\Entity\AdminUserInterface;
use BeHappy\SyliusRightsManagementPlugin\Entity\GroupInterface;
use BeHappy\SyliusRightsManagementPlugin\Service\GroupServiceInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class AdminMenuListener
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Menu
 */
class AdminMenuListener
{
    /** @var GroupServiceInterface */
    protected $groupService;
    /** @var TokenStorage */
    protected $tokenStorage;
    
    /**
     * AdminMenuListener constructor.
     *
     * @param GroupServiceInterface $groupService
     * @param TokenStorage $tokenStorage
     */
    public function __construct(GroupServiceInterface $groupService, TokenStorage $tokenStorage)
    {
        $this->groupService = $groupService;
        $this->tokenStorage = $tokenStorage;
    }
    
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        
        $subMenu = $menu->addChild('be_happy.rights_management')
            ->setLabel('be_happy_rights_management.ui.rights_management');
        
        $subMenu->addChild('be_happy.rights_management.groups', [
            'route' => 'be_happy_rights_management_admin_group_index'
        ])->setLabel('be_happy_rights_management.ui.groups');
    }
    
    /**
     * Removing all routes that user can not access
     *
     * @param MenuBuilderEvent $event
     */
    public function removeAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $categories = $menu->getChildren();
        $user = $this->tokenStorage->getToken()->getUser();
        
        foreach ($categories as $category) {
            $items = $category->getChildren();
            foreach ($items as $item) {
                $route = $item->getExtra('routes')[0]['route'];
                if ($user instanceof AdminUserInterface && $user->getGroup() instanceof GroupInterface && $route != null) {
                    if (!$this->groupService->isUserGranted($route, $user)) {
                        $category->removeChild($item);
                    }
                }
            }
            if (!$category->hasChildren()) {
                $menu->removeChild($category);
            }
        }
    }
}