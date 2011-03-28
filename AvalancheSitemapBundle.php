<?php

namespace Bundle\Avalanche\SitemapBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Bundle\Avalanche\SitemapBundle\DependencyInjection\Compiler\AddProvidersToChainPass;

class AvalancheSitemapBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddProvidersToChainPass());
    }
}
