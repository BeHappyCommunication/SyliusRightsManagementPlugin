<?php

namespace BeHappy\SyliusRightsManagementPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

class Right implements ResourceInterface
{
    protected $id;
    /** @var string */
    protected $route;
    /** @var bool */
    protected $granted = false;
    /** @var bool|Group */
    protected $group = null;
    /** @var string */
    protected $name = "";

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(?string $route): void
    {
        $this->route = $route;
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
     * @return Group|bool
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group|bool $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }
}