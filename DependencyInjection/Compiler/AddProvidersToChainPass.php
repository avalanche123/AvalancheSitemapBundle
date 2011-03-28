<?php

namespace Avalanche\Bundle\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddProvidersToChainPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $chain = $container->getDefinition('sitemap.provider.chain');

        foreach ($container->findTaggedServiceIds('sitemap.provider') as $id => $tag) {
            $chain->addMethodCall('add', array(new Reference($id)));
        }
    }
}
