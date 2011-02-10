<?php

namespace Bundle\Avalanche\SitemapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\FileLocator;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use InvalidArgumentException;

class SitemapExtension extends Extension
{
    public function configLoad(array $configs, ContainerBuilder $container)
    {
        foreach ($configs as $config) {
            $this->doConfigLoad($config, $container);
        }

        if(!$container->hasParameter('sitemap.base_url')) {
            throw new InvalidArgumentException('Please provide a base_url in the sitemap configuration');
        }
    }

    public function doConfigLoad(array $config, ContainerBuilder $container)
    {
        if ( ! $container->hasDefinition('sitemap.controller')) {
            $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
            $loader->load('sitemap.xml');
        }

        foreach (array('collection', 'database') as $key) {
            if (isset($config[$key])) {
                $container->setParameter(sprintf("sitemap.mongodb.%s", $key), $config[$key]);
            }
        }

        if(isset($config['base_url'])) {
            $container->setParameter('sitemap.base_url', $config['base_url']);
        }
    }

    public function getAlias()
    {
        return 'sitemap';
    }

    public function getNamespace()
    {
        return 'http://xmlns.avalanche123.com/dic/sitemap';
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }
}
