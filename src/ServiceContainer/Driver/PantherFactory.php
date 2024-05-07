<?php
declare(strict_types=1);

namespace Robertfausk\Behat\PantherExtension\ServiceContainer\Driver;

use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Robertfausk\Behat\PantherExtension\ServiceContainer\PantherConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Robert Freigang <robertfreigang@gmx.de>
 */
class PantherFactory implements DriverFactory
{
    /**
     * {@inheritdoc}
     */
    public function getDriverName()
    {
        return 'panther';
    }

    /**
     * {@inheritdoc}
     */
    public function supportsJavascript()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $configuration = new PantherConfiguration();
        $builder->append($configuration->addOptionsNode());
        $builder->append($configuration->addKernelOptionsNode());
        $builder->append($configuration->addManagerOptionsNode());
    }

    /**
     * {@inheritdoc}
     */
    public function buildDriver(array $config)
    {
        if (!class_exists('Behat\Mink\Driver\PantherDriver')) {
            throw new \RuntimeException(
                'Install MinkPantherDriver in order to use panther driver.'
            );
        }

        // php-webdriver expects ChromeOptions instead of array since v1.15.0
        // see: https://github.com/robertfausk/behat-panther-extension/issues/16
        if (isset($config['manager_options']['capabilities'][ChromeOptions::CAPABILITY]) && 'goog:chromeOptions' === ChromeOptions::CAPABILITY) {
            $chromeOptions = new ChromeOptions();
            foreach ($config['manager_options']['capabilities'][ChromeOptions::CAPABILITY] as $name => $value) {
                switch ($name) {
                    case 'prefs':
                        $chromeOptions->setExperimentalOption($name, $value);
                        break;
                    case 'args':
                        $chromeOptions->addArguments($value);
                        break;
                    case 'extensions':
                        $chromeOptions->addExtensions($value);
                        break;
                    case 'binary':
                        $chromeOptions->setBinary($value);
                        break;
                }
            }
            $config['manager_options']['capabilities'][ChromeOptions::CAPABILITY] = $chromeOptions;
        }

        return new Definition(
            'Behat\Mink\Driver\PantherDriver',
            array(
                $config['options'] ?? [],
                $config['kernel_options'] ?? [],
                $config['manager_options'] ?? [],
            )
        );
    }
}
