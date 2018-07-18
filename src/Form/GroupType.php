<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\Form;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class GroupType
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Form
 */
class GroupType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'be_happy_rights_management.ui.name'
            ])
            ->add('rights', CollectionType::class, [
                'label' => 'be_happy_rights_management.ui.rights',
                'entry_type' => RightType::class
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
                $form = $event->getForm();
                $data = $event->getData();
                $form->add('code', TextType::class, [
                    'attr' => ['disabled' => !empty($data->getCode())]
                ]);
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event){
                if (empty($event->getData()['code'])) {
                    $event->getForm()->remove('code');
                }
            })
        ;

    }
}