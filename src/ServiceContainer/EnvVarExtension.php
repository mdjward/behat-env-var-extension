<?php
/**
 * EnvVarExtension.php
 * Definition of class EnvVarExtension
 *
 * Created Nov 8, 2016, 2:39:05 PM
 * 
 * @author EnvVarExtension
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\Behat\EnvVarExtension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * EnvVarExtension
 *
 * @author M.D.Ward <md.ward@quidco.com>
 */
class EnvVarExtension implements Extension
{

    /**
     * 
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
            ->scalarNode('prefix')
            ->defaultValue('env')
        ;
    }

    /**
     * 
     * @return string
     */
    public function getConfigKey()
    {
        return 'env_var';
    }

    /**
     * 
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * 
     * @param ContainerBuilder $container
     * @param array $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $prefix = (empty($config['prefix']) ? '' : $config['prefix'] . '.');

        foreach (filter_input_array(INPUT_SERVER) as $name => $value) {
            $container->setParameter($prefix . strtolower($name), $value);
        }
    }

    /**
     * 
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
    }

}
