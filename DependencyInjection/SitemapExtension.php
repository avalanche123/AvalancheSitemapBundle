<?php

namespace Bundle\Avalanche\SitemapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SitemapExtension extends Extension
{
    public function configLoad(array $configs, ContainerBuilder $container)
    {
        foreach ($configs as $config) {
            $this->doConfigLoad($config, $container);
        }
    }

    public function doConfigLoad(array $config, ContainerBuilder $container)
    {
        if ( ! $container->hasDefinition('sitemap.controller')) {
            $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
            $loader->load('sitemap.xml');
        }

        foreach (array('collection', 'database') as $key) {
            if (isset($config[$key])) {
                $container->setParameter(sprintf("sitemap.mongodb.%s", $key), $config[$key]);
            }
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
