<?php
declare(strict_types=1);

namespace Robertfausk\Behat\PantherExtension\ServiceContainer;

use Behat\MinkExtension\ServiceContainer\MinkExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Robertfausk\Behat\PantherExtension\ServiceContainer\Driver\PantherFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Robert Freigang <robertfreigang@gmx.de>
 */
final class PantherExtension implements ExtensionInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container): void
    {
    }

    /**
     * @inheritdoc
     */
    public function getConfigKey(): string
    {
        return 'panther';
    }

    /**
     * @inheritdoc
     */
    public function initialize(ExtensionManager $extensionManager): void
    {
        /** @var MinkExtension|null $minkExtension */
        $minkExtension = $extensionManager->getExtension('mink');

        if ($minkExtension === null) {
            return;
        }

        $minkExtension->registerDriverFactory(new PantherFactory());
    }

    /**
     * @inheritdoc
     */
    public function configure(ArrayNodeDefinition $builder): void
    {
    }

    /**
     * @inheritdoc
     */
    public function load(ContainerBuilder $container, array $config): void
    {
    }
}
