<?php
/**
 * EnvVarExtensionTest.php
 * Definition of class EnvVarExtensionTest
 *
 * Created Nov 8, 2016, 7:28:04 PM
 * 
 * @author Matt Ward <dev@mattdw.co.uk>
 */

namespace Mdjward\Behat\EnvVarExtension\ServiceContainer;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * EnvVarExtensionTest
 *
 * @author Matt Ward <dev@mattdw.co.uk>
 */
class EnvVarExtensionTest extends TestCase
{

    /**
     *
     * @var EnvVarExtension
     */
    private $extension;

    public function setUp()
    {
        $this->extension = new EnvVarExtension();
    }

    public function testExtensionHasCorrectType()
    {
        $this->assertInstanceOf(
            \Behat\Testwork\ServiceContainer\Extension::class,
            $this->extension
        );
    }

    public function testConfigKeyReturnsCorrectValue()
    {
        $this->assertSame(
            'env_var',
            $this->extension->getConfigKey()
        );
    }

}
