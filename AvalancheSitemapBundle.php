<?php

namespace Avalanche\Bundle\SitemapBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Avalanche\Bundle\SitemapBundle\DependencyInjection\Compiler\AddProvidersToChainPass;

class AvalancheSitemapBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddProvidersToChainPass());
    }
}
