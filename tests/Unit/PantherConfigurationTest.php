<?php
declare(strict_types=1);

namespace Tests\Unit;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Robertfausk\Behat\PantherExtension\ServiceContainer\PantherConfiguration;

/**
 * @author Robert Freigang <robertfreigang@gmx.de>
 */
class PantherConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    public function validConfigurationProvider(): array
    {
        return [
            'empty options' => [['options' => []]],
        ];
    }

    public function invalidConfigurationProvider(): array
    {
        return [
            'misspelled options' => [['opions' => []], 'Unrecognized option "opions"'],
        ];
    }

    /**
     * @dataProvider invalidConfigurationProvider
     *
     * @param array  $configurationOptions
     * @param string $message
     */
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
     * @dataProvider validConfigurationProvider
     *
     * @param array $configurationOptions
     */
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
                ['options' => ['hostname' => '127.0.0.1']],
            ],
            [
                'options' => [
                    'hostname' => '127.0.0.1',
                ],
            ]
        );
    }

    protected function getConfiguration(): PantherConfiguration
    {
        return new PantherConfiguration();
    }
}
