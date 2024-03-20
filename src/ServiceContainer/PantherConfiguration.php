<?php
declare(strict_types=1);

namespace Robertfausk\Behat\PantherExtension\ServiceContainer;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Robert Freigang <robertfreigang@gmx.de>
 */
class PantherConfiguration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('panther');
        if (\method_exists($treeBuilder, 'getRootNode')) {
            $root = $treeBuilder->getRootNode();
        } else {
            $root = $treeBuilder->root('panther');
        }

        $root->children()
            ->append($this->addOptionsNode())
            ->append($this->addKernelOptionsNode())
            ->append($this->addManagerOptionsNode())
        ->end();

        return $treeBuilder;
    }

    public function addOptionsNode(): ArrayNodeDefinition
    {
        $treeBuilder = new TreeBuilder('options');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $root = $treeBuilder->getRootNode();
        } else {
            $root = $treeBuilder->root('options');
        }

        $node = $root
            ->info(
                "These are the options passed as first argument to PantherTestCaseTrait::createPantherClient client constructor."
            )
            ->ignoreExtraKeys()
            ->variablePrototype()
            ->end()
        ;

        return $node;
    }

    public function addKernelOptionsNode(): ArrayNodeDefinition
    {
        $treeBuilder = new TreeBuilder('kernel_options');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $root = $treeBuilder->getRootNode();
        } else {
            $root = $treeBuilder->root('kernel_options');
        }

        $node = $root
            ->info(
                "These are the options passed as second argument to PantherTestCaseTrait::createPantherClient client constructor."
            )
            ->ignoreExtraKeys()
            ->scalarPrototype()
            ->end()
        ;

        return $node;
    }

    public function addManagerOptionsNode(): ArrayNodeDefinition
    {
        $treeBuilder = new TreeBuilder('manager_options');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $root = $treeBuilder->getRootNode();
        } else {
            $root = $treeBuilder->root('manager_options');
        }

        $node = $root
            ->info(
                "These are the options passed as third argument to PantherTestCaseTrait::createPantherClient client constructor."
            )
            ->ignoreExtraKeys()
            ->variablePrototype()
            ->end()
        ;

        return $node;
    }
}
