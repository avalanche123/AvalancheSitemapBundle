<?php

namespace Avalanche\Bundle\SitemapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use InvalidArgumentException;

class AvalancheSitemapExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = array();
        foreach ($configs as $c) {
            $config = array_merge($config, $c);
        }

        if (!isset($config['base_url'])) {
            throw new InvalidArgumentException('Please provide a base_url in the sitemap configuration');
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('sitemap.xml');

        foreach (array('collection', 'database') as $key) {
            if (isset($config[$key])) {
                $container->setParameter(sprintf("sitemap.mongodb.%s", $key), $config[$key]);
            }
        }

        if(isset($config['base_url'])) {
            $container->setParameter('sitemap.base_url', $config['base_url']);
        }
    }
}
