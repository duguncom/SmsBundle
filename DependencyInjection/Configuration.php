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
                ->scalarNode('debug_number')
                ->end()
                ->arrayNode('providers')
                    ->prototype('array')
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
                ->end()
            ->end();

        return $treeBuilder;
    }
}
