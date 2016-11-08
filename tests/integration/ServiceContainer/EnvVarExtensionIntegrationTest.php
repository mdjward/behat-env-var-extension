<?php
/**
 * EnvVarExtensionIntegrationTest.php
 * Definition of class EnvVarExtensionIntegrationTest
 *
 * Created Nov 8, 2016, 7:29:38 PM
 * 
 * @author EnvVarExtensionIntegrationTest
 * Copyright (c) 2016, Maple Syrup Media Ltd
 */

namespace Mdjward\Behat\EnvVarExtension\ServiceContainer;

use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * EnvVarExtensionIntegrationTest
 *
 * @author M.D.Ward <md.ward@quidco.com>
 */
class EnvVarExtensionIntegrationTest extends TestCase
{
    
    /**
     *
     * @var EnvVarExtension
     */
    private $extension;
    
    /**
     *
     * @var TreeBuilder
     */
    private $treeBuilder;

    /**
     *
     * @var array
     */
    private $validConfiguration = [
        'env_var' => [
            'prefix' => 'env'
        ]
    ];

    /**
     * 
     */
    public function setUp()
    {
        $this->extension = new EnvVarExtension();

        $this->treeBuilder = new TreeBuilder();
    }

    /**
     * 
     */
    public function testConfigureIsSuccessfulWithValidConfiguration()
    {
        $configKey = $this->extension->getConfigKey();

        $this->extension->configure($this->treeBuilder->root($configKey));

        $processedConfig = (new Processor())->process(
            $this->treeBuilder->buildTree(),
            $this->validConfiguration
        );

        $this->assertSame(
            $this->validConfiguration[$configKey],
            $processedConfig
        );
    }
    
    public function testConfigureIsSuccessfulWithInvalidConfiguration()
    {
        $this->expectException(InvalidConfigurationException::class);
        
        $this->extension->configure(
            $this->treeBuilder->root($this->extension->getConfigKey())
        );

        (new Processor())->process(
            $this->treeBuilder->buildTree(),
            [
                'env_var' => [
                    'random' => true
                ]
            ]
        );
    }

    public function testLoadInjectsParametersIntoContainer()
    {
        $configKey = $this->extension->getConfigKey();
        
        $this->extension->load(
            ($containerBuilder = new ContainerBuilder()),
            ($config = $this->validConfiguration[$configKey])
        );
        
        $prefix = $config['prefix'];

        foreach (filter_input_array(INPUT_SERVER) as $name => $value) {
            $parameterName = sprintf(
                '%s.%s',
                $prefix,
                strtolower($name)
            );

            $this->assertTrue(
                $containerBuilder->hasParameter($parameterName)
            );

            $this->assertSame(
                $value,
                $containerBuilder->getParameter($parameterName)
            );
        }
    }
    
}
