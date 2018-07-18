<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\Event;

use BeHappy\SyliusRightsManagementPlugin\Entity\AdminUserInterface;
use BeHappy\SyliusRightsManagementPlugin\Entity\Group;
use BeHappy\SyliusRightsManagementPlugin\Service\GroupServiceInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ControllerListener
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Event
 */
class ControllerListener
{
    
    /** @var array|null */
    protected $arrayRouter;
    /** @var GroupServiceInterface */
    protected $groupService;
    /** @var RequestStack */
    protected $requestStack;
    /** @var Session */
    protected $session;
    /** @var TokenStorageInterface */
    protected $tokenStorage;
    
    /**
     * ControllerListener constructor.
     *
     * @param GroupServiceInterface $groupService
     * @param RequestStack          $requestStack
     * @param Session               $session
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(GroupServiceInterface $groupService, RequestStack $requestStack, Session $session,
                                TokenStorageInterface $tokenStorage)
    {
        $this->groupService = $groupService;
        $this->requestStack = $requestStack;
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
    }
    
    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event): void
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');
        $controller = $event->getController();
        $service = $this->groupService;

        if ($controller[0] instanceof Controller) {
            $user = $this->getUser();
            if ($user instanceof AdminUserInterface && $user->getGroup() instanceof Group) {
                if (!$service->isUserGranted($route, $user)) {
                    $right = $service->getRight($route, $user);
                    $redirectRoute = $service->getRedirectRoute($right);
                    $redirectMessage = $service->getRedirectMessage($right);
                    if (!$this->requestStack->getCurrentRequest()->isXmlHttpRequest()) {
                        $this->redirectUser($redirectRoute, $redirectMessage, $event);
                    }
                }
            }
        }
    }

    /**
     * @param string                $route
     * @param string                $message
     * @param FilterControllerEvent $event
     */
    protected function redirectUser(string $route, string $message, FilterControllerEvent $event): void
    {
        $this->session->getFlashBag()->add('error', $message);
        $event->setController(function() use ($route) {
            return new RedirectResponse($route);
        });
    }

    /**
     * @return UserInterface|null
     */
    protected function getUser(): ?UserInterface
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }
}