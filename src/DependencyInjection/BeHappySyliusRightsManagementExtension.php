<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class BeHappySyliusRightsManagementExtension
 *
 * @package BeHappy\SyliusRightsManagementPlugin\DependencyInjection
 */
final class BeHappySyliusRightsManagementExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        
        $container->setParameter('behappy.rights_management.rights', $config['rights']);
    }
}
