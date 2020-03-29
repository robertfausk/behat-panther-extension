<?php
declare(strict_types=1);

namespace Tests\Unit\Driver;

use PHPUnit\Framework\TestCase;
use Robertfausk\Behat\PantherExtension\ServiceContainer\Driver\PantherFactory;

/**
 * @author Robert Freigang <robertfreigang@gmx.de>
 */
class PantherFactoryTest extends TestCase
{
    public function test_support_javascript_is_true(): void
    {
        $pantherFactory = new PantherFactory();
        $this->assertTrue($pantherFactory->supportsJavascript());
    }

    public function test_driver_name_is_panther(): void
    {
        $pantherFactory = new PantherFactory();
        $this->assertSame('panther', $pantherFactory->getDriverName());
    }

    public function test_build_driver_with_default_options(): void
    {
        /** @see \Symfony\Component\Panther\PantherTestCaseTrait::$defaultOptions **/
        $options = [
            'webServerDir' => __DIR__.'/../../../../public',
            'hostname' => '127.0.0.1',
            'port' => 9080,
            'router' => '',
            'external_base_uri' => null,
            'readinessPath' => '',
            'browser' => 'chrome',
        ];

        $config = [
            'options' => $options,
        ];
        $pantherFactory = new PantherFactory();
        $definition = $pantherFactory->buildDriver($config);
        $arguments = $definition->getArguments();

        $this->assertArrayHasKey(0, $arguments, 'Arguments of definition should not be empty.');
        $this->assertSame($options, $arguments[0]);
    }

    public function test_build_driver_with_empty_options(): void
    {
        $options = [];

        $config = [
            'options' => $options,
        ];
        $pantherFactory = new PantherFactory();
        $definition = $pantherFactory->buildDriver($config);
        $arguments = $definition->getArguments();

        $this->assertArrayHasKey(0, $arguments, 'Arguments of definition should not be empty.');
        $this->assertSame($options, $arguments[0]);
    }

    public function test_build_driver_without_options(): void
    {
        $config = [];
        $pantherFactory = new PantherFactory();
        $definition = $pantherFactory->buildDriver($config);
        $arguments = $definition->getArguments();

        $this->assertArrayHasKey(0, $arguments, 'Arguments of definition should not be empty.');
        $this->assertSame([], $arguments[0]);
    }
}
