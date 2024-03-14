<?php

namespace Malefici\Symfony\MetabaseBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MetabaseExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('metabase.parameter.site_url', $config['site_url']);
        $container->setParameter('metabase.parameter.secret_key', $config['secret_key']);
        $container->setParameter('metabase.parameter.token_expiration', $config['token_expiration']);
        $container->setParameter('metabase.parameter.appearance', $config['appearance']);

        $fileLocator = new FileLocator(__DIR__.'/../../config');
        $loader = new YamlFileLoader($container, $fileLocator);
        $loader->load('services.yaml');
    }
}
