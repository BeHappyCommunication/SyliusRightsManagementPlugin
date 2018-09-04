<?php

namespace BeHappy\SyliusRightsManagementPlugin\Service;

use BeHappy\SyliusRightsManagementPlugin\Entity\AdminUserInterface;
use BeHappy\SyliusRightsManagementPlugin\Entity\GroupInterface;
use BeHappy\SyliusRightsManagementPlugin\Entity\Right;
use BeHappy\SyliusRightsManagementPlugin\Entity\RightInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class GroupService
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Service
 */
class GroupService implements GroupServiceInterface
{
    /** @var array|null */
    protected $arrayRouter;
    /** @var array */
    protected $config = [];
    /** @var RouterInterface */
    protected $router;
    /** @var RepositoryInterface */
    protected $rightRepository;
    
    /**
     * GroupService constructor.
     *
     * @param array               $config
     * @param RouterInterface     $router
     * @param RepositoryInterface $rightRepository
     */
    public function __construct(array $config, RouterInterface $router, RepositoryInterface $rightRepository)
    {
        $this->config = $config;
        $this->router = $router;
        $this->rightRepository = $rightRepository;
    }

    public function initializeArrayRouter(): void
    {
        $router = $this->router;
        $this->arrayRouter = $router->getRouteCollection()->all();
    }

    /**
     * Add missing rights to group entity.
     *
     * @param GroupInterface $group
     *
     * @throws \Exception
     */
    public function createMissingRights(GroupInterface &$group): void
    {
        $config = $this->config;
        $rights = new ArrayCollection();
        $rightRepository = $this->rightRepository;
        foreach ($config as $family) {
            foreach ($family as $raw_right) {
                $routes = [];
                $redirectTo = "";
                $redirectMessage = "";

                if (!isset($raw_right['route']) && !isset($raw_right['routes'])) {
                    throw new \Exception("You need to define routes");
                }
                if (isset($raw_right['routes'])) {
                    $routes = $raw_right['routes'];
                }
                if (isset($raw_right['route'])) {
                    $routes[] = $raw_right['route'];
                }
                if (isset($raw_right['redirect_to'])) {
                    $redirectTo = $raw_right['redirect_to'];
                }
                if (isset($raw_right['redirect_message'])) {
                    $redirectMessage = $raw_right['redirect_message'];
                }

                $exclude = $raw_right['exclude'];
                $name = $raw_right['name'];

                $right = $rightRepository->findOneBy([
                    'name' => $name,
                    'group' => $group
                ]);

                if (!$right instanceof Right) {
                    $right = new Right();
                    $right->setGranted(false);
                    $right->setGroup($group);
                }

                $right->setRoutes($routes);
                $right->setExclude($exclude);
                $right->setRedirectTo($redirectTo);
                $right->setRedirectMessage($redirectMessage);
                $right->setName($name);
                $rights->add($right);
            }
        }

        $group->setRights($rights);
    }

    /**
     * @param string             $route
     * @param AdminUserInterface $user
     *
     * @return bool
     */
    public function isUserGranted(string $route, AdminUserInterface $user): bool
    {
        if (preg_match ("/sylius_admin_get_/", $route)) {
            return true;
        }
        if (preg_match ("/sylius_admin_render_/", $route)) {
            return true;
        }
        if (preg_match("/sylius_admin_partial_/", $route) || preg_match ("/sylius_admin_ajax_/", $route)) {
            return true;
        }
        if (preg_match("/sylius_shop_partial_/", $route)) {
            return true;
        }
        $right = $this->getRight($route, $user);

        if (!$right instanceof Right){
            return false;
        }
        
        return $right->isGranted();
    }

    /**
     * @param string             $route
     * @param AdminUserInterface $user
     *
     * @return RightInterface|null
     */
    public function getRight(string $route, AdminUserInterface $user): ?RightInterface
    {
        /** @var Right $right */
        $rights = $user->getGroup()->getRights();
        foreach ($rights as $right) {
            $rightRoutes = $this->getRightRoutes($right);
            // If the right match the current route.
            if (in_array($route, $rightRoutes)) {
                return $right;
            }
        }
        return null;
    }

    /**
     * @param RightInterface $right
     *
     * @return array
     */
    public function getRightRoutes(RightInterface $right): array
    {
        $rightRoutes = [];
        $globalExclude = [];
        foreach ($right->getRoutes() as $crawledRoute) {
            $rightRoutes = array_merge($this->resolveGlobalsRoutes($crawledRoute), $rightRoutes);
        }
        foreach ($right->getExclude() as $toExclude) {
            $globalExclude = array_merge($this->resolveGlobalsRoutes($toExclude), $globalExclude);
        }
        foreach ($rightRoutes as $key => $exclude) {
            if (in_array($exclude, $globalExclude)) {
                unset($rightRoutes[$key]);
            }
        }
        return $rightRoutes;
    }

    /**
     * @param string $globalRoute
     *
     * @return array
     */
    public function resolveGlobalsRoutes(string $globalRoute): array
    {
        if (strpos($globalRoute, '*')) {
            $globalRoute = substr($globalRoute, 0, -2);
        }
        $pattern = '/^'.$globalRoute.'/';
        $routes = $this->arrayRouter;
        $selectedRoutes = array();

        foreach ($routes as $route => $value) {
            if (preg_match($pattern, $route)) {
                $selectedRoutes[] = $route;
            }
        }
        return $selectedRoutes;
    }

    /**
     * @param RightInterface $right
     *
     * @return string
     */
    public function getRedirectRoute(?RightInterface $right): string
    {
        $redirectUrl = $this->router->generate('sylius_admin_dashboard');
        if ($right instanceof Right && !empty($right->getRedirectTo())) {
            $redirectUrl = $this->router->generate($right->getRedirectTo());
        }
        return $redirectUrl;
    }

    /**
     * @param RightInterface $right
     *
     * @return string
     */
    public function getRedirectMessage(?RightInterface $right): string
    {
        $redirectMessage = "be_happy_rights_management.message.access_denied";
        if ($right instanceof Right && !empty($right->getRedirectMessage())) {
            $redirectMessage = $right->getRedirectMessage();
        }
        return $redirectMessage;
    }

}
