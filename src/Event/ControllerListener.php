<?php

namespace BeHappy\SyliusRightsManagementPlugin\Event;

use BeHappy\SyliusRightsManagementPlugin\Entity\AdminUserInterface;
use BeHappy\SyliusRightsManagementPlugin\Entity\Group;
use BeHappy\SyliusRightsManagementPlugin\Entity\Right;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ControllerListener implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        $route = $request->attributes->get('_route');
        $controller = $event->getController();

        // Prevent app from crashing when $controller is not an array.
        if (!is_array($controller)) {
            return;
        }
        
        // If we are in a controller.
        if ($controller[0] instanceof Controller) {
            $user = $this->getUser();

            // If the user is an admin user.
            if ($user instanceof AdminUserInterface) {
                // If the user has a group.
                if ($user->getGroup() instanceof Group) {
                    /** @var Right $right */
                    foreach ($user->getGroup()->getRights() as $right) {
                        // If the right match the current route.
                        if ($right->getRoute() === $route) {
                            // If user is not granted, throw a Access Denied.
                            if (!$right->isGranted()) {
                                throw new AccessDeniedException();
                            }
                            break;
                        }
                    }
                }
            }
        }
    }

    /**
     * @return UserInterface|null
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }
}
