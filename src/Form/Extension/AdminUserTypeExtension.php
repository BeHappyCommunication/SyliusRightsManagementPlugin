<?php

namespace BeHappy\SyliusRightsManagementPlugin\Form\Extension;

use BeHappy\SyliusRightsManagementPlugin\Entity\Group;
use Sylius\Bundle\CoreBundle\Form\Type\User\AdminUserType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class AdminUserTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('group', EntityType::class, [
                'class' => Group::class
            ])
        ;
    }
    
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType(): string
    {
        return AdminUserType::class;
    }
}