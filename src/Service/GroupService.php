<?php

namespace BeHappy\SyliusRightsManagementPlugin\Service;

use BeHappy\SyliusRightsManagementPlugin\Entity\Group;
use BeHappy\SyliusRightsManagementPlugin\Entity\Right;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class GroupService implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Add missing rights to group entity.
     * @param Group $group
     */
    public function createMissingRights(Group &$group): void
    {
        $config = $this->container->getParameter('behappy.rights_management.rights');
        $rights = new ArrayCollection();

        /** @var RepositoryInterface $rightRepository */
        $rightRepository = $this->container->get('be_happy_rights_management.repository.right');

        foreach ($config as $family) {
            foreach ($family as $raw_right) {
                $right = $rightRepository->findOneBy([
                    'route' => $raw_right['route'],
                    'group' => $group
                ]);

                if (!$right instanceof Right) {
                    $right = new Right();

                    $right->setRoute($raw_right['route']);
                    $right->setGranted(false);
                    $right->setGroup($group);
                }

                $right->setName($raw_right['name']);
                $rights->add($right);
            }
        }

        $group->setRights($rights);
    }
}