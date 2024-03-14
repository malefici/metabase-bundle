<?php

namespace Malefici\Symfony\MetabaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('metabase');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('site_url')->isRequired()->end()
                ->scalarNode('secret_key')->isRequired()->end()
                ->scalarNode('token_expiration')->defaultValue('+1 hour')->end()
                ->booleanNode('border')->defaultTrue()->end()
                ->booleanNode('title')->defaultTrue()->end()
                ->enumNode('theme')->values(['light', 'dark', 'transparent'])->end()
            ->end();

        return $treeBuilder;
    }
}
