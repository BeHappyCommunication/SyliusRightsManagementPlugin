<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

/**
 * Class Right
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Entity
 */
class Right implements RightInterface
{
    protected $id;
    /** @var array */
    protected $routes;
    /** @var  array */
    protected $exclude;
    /** @var bool */
    protected $granted = false;
    /** @var GroupInterface */
    protected $group = null;
    /** @var string */
    protected $name = "";
    /** @var string */
    protected $redirectTo = "";
    /** @var string */
    protected $redirectMessage = "";
    
    /**
     * Right constructor.
     */
    public function __construct()
    {
        $this->setRoutes([]);
    }

    /**
     * @return string
     */
    public function getRedirectTo(): string
    {
        return $this->redirectTo;
    }

    /**
     * @param string $redirectTo
     */
    public function setRedirectTo(string $redirectTo): void
    {
        $this->redirectTo = $redirectTo;
    }

    /**
     * @return string
     */
    public function getRedirectMessage(): string
    {
        return $this->redirectMessage;
    }

    /**
     * @param string $redirectMessage
     */
    public function setRedirectMessage(string $redirectMessage): void
    {
        $this->redirectMessage = $redirectMessage;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array|string[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param array|string[] $routes
     */
    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * @param string $route
     *
     * @return bool
     */
    public function addRoute(string $route): bool
    {
        $key = array_search($route, $this->routes, true);
        if ($key === false) {
            $this->routes[] = $route;
        }
    
        return true;
    }

    /**
     * @param string $route
     *
     * @return bool
     */
    public function removeRoute(string $route): bool
    {
        $key = array_search($route, $this->routes, true);
        if ($key === false) {
            return false;
        }

        unset($this->routes[$key]);
        
        return true;
    }

    /**
     * @return array
     */
    public function getExclude(): array
    {
        return $this->exclude;
    }

    /**
     * @param array $exclude
     */
    public function setExclude(array $exclude): void
    {
        $this->exclude = $exclude;
    }

    /**
     * @return bool
     */
    public function isGranted(): bool
    {
        return $this->granted;
    }

    /**
     * @param bool $granted
     */
    public function setGranted(bool $granted): void
    {
        $this->granted = $granted;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return GroupInterface
     */
    public function getGroup(): GroupInterface
    {
        return $this->group;
    }

    /**
     * @param GroupInterface $group
     */
    public function setGroup(GroupInterface $group): void
    {
        $this->group = $group;
    }
}