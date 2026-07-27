<?php
declare(strict_types=1);

namespace Tests\Unit;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Robertfausk\Behat\PantherExtension\ServiceContainer\PantherConfiguration;

/**
 * @author Robert Freigang <robertfreigang@gmx.de>
 */
class PantherConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    public static function validConfigurationProvider(): array
    {
        return [
            'empty options' => [['options' => []]],
        ];
    }

    public static function invalidConfigurationProvider(): array
    {
        return [
            'misspelled options' => [['opions' => []], 'Unrecognized option "opions"'],
        ];
    }

    /**
     * @param array  $configurationOptions
     * @param string $message
     */
    #[DataProvider('invalidConfigurationProvider')]
    public function test_invalid_configuration(array $configurationOptions, string $message): void
    {
        $this->assertConfigurationIsInvalid(
            [
                $configurationOptions,
            ],
            $message
        );
    }

    /**
     * @param array $configurationOptions
     */
    #[DataProvider('validConfigurationProvider')]
    public function test_valid_configuration(array $configurationOptions): void
    {
        $this->assertConfigurationIsValid(
            [
                $configurationOptions,
            ]
        );
    }

    public function test_processed_configuration(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                ['options' => ['hostname' => '127.0.0.1', 'env' => ['APP_ENV' => 'dev']]],
            ],
            [
                'options' => [
                    'hostname' => '127.0.0.1',
                    'env' => ['APP_ENV' => 'dev'],
                ],
                'kernel_options' => [],
                'manager_options' => [],
            ]
        );
    }

    public function test_processed_configuration_for_manager_options(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'manager_options' => [
                        'connection_timeout_in_ms' => '5000',
                        'request_timeout_in_ms' => '120000',
                        'capabilities' => [
                                'goog:chromeOptions' => [
                                    'prefs' => [
                                        'download.default_directory' => '/var/www/html/tests/files/Downloads',
                                    ],
                                ],
                        ],
                    ],
                ],
            ],
            [
                'manager_options' => [
                    'connection_timeout_in_ms' => '5000',
                    'request_timeout_in_ms' => '120000',
                    'capabilities' => [
                        'goog:chromeOptions' => [
                            'prefs' => [
                                'download.default_directory' => '/var/www/html/tests/files/Downloads',
                            ],
                        ],
                    ],
                ],
            ],
            'manager_options'
        );
    }

    protected function getConfiguration(): PantherConfiguration
    {
        return new PantherConfiguration();
    }
}
