<?php

namespace BeHappy\SyliusRightsManagementPlugin\Form;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RightType extends AbstractResourceType implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'be_happy_rights_management.ui.name'
            ])
            ->add('granted', CheckboxType::class, [
                'label' => 'be_happy_rights_management.ui.granted'
            ])
        ;
    }
}