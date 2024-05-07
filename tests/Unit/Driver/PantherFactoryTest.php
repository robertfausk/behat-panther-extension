<?php
declare(strict_types=1);

namespace Tests\Unit\Driver;

use Facebook\WebDriver\Chrome\ChromeOptions;
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

    public function test_build_chrome_driver_with_chrome_options_as_object_instead_of_array(): void
    {
        $config = [
            'manager_options' => [
                'connection_timeout_in_ms' => '5000',
                'request_timeout_in_ms' => '120000',
                'capabilities' => [
                    'goog:chromeOptions' => [
                        'prefs' => [
                            'download.default_directory' => '/var/www/html/tests/files/Downloads',
                        ],
                        'args' => ['start-maximized'],
                        'binary' => ['/path/to/acme'],
                        'extensions' => ['tests/fixtures/extension_dummy.ext'],
                    ],
                ],
            ],
        ];
        $pantherFactory = new PantherFactory();
        $definition = $pantherFactory->buildDriver($config);
        $arguments = $definition->getArguments();

        $this->assertArrayHasKey(2, $arguments, 'Arguments of definition should not be empty.');
        $this->assertArrayHasKey('connection_timeout_in_ms', $arguments[2]);
        $this->assertSame('5000', $arguments[2]['connection_timeout_in_ms']);
        $this->assertArrayHasKey('request_timeout_in_ms', $arguments[2]);
        $this->assertSame('120000', $arguments[2]['request_timeout_in_ms']);
        $this->assertArrayHasKey('capabilities', $arguments[2]);
        $this->assertArrayHasKey('goog:chromeOptions', $arguments[2]['capabilities']);
        $chromeOptions = $arguments[2]['capabilities']['goog:chromeOptions'];

        if ('goog:chromeOptions' === ChromeOptions::CAPABILITY) {
            $this->assertInstanceOf(ChromeOptions::class, $chromeOptions);
            $chromeOptions = $chromeOptions->toArray();
            // base64 encoded value of extension file content
            $this->assertSame(['MTIzNDU2Nzg5MA=='], $chromeOptions['extensions']);
        } else {
            $this->assertSame(['tests/fixtures/extension_dummy.ext'], $chromeOptions['extensions']);
        }

        $this->assertSame(['download.default_directory' => '/var/www/html/tests/files/Downloads'], $chromeOptions['prefs']);
        $this->assertSame(['start-maximized'], $chromeOptions['args']);
        $this->assertSame(['/path/to/acme'], $chromeOptions['binary']);
    }
}
