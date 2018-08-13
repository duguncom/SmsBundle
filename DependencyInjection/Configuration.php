<?php

namespace Dugun\Bundle\SmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @author Farhad Safarov <farhad.safarov@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dugun_sms');

        $rootNode
            ->children()
                ->scalarNode('gateway_provider')
                    ->validate()
                        ->ifNotInArray(['infobip', 'mobily'])
                        ->thenInvalid('It is not a supported SMS gateway provider')
                    ->end()
                ->end()
                ->booleanNode('disable')
                    ->defaultFalse()
                ->end()
                ->arrayNode('credentials')
                    ->isRequired()
                    ->children()
                        ->scalarNode('username')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('password')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('custom')
                    ->ignoreExtraKeys(false)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
