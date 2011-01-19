<?php

namespace Bundle\Avalanche\SitemapBundle\Sitemap;

use Bundle\Avalanche\SitemapBundle\Sitemap;

class ProviderChain implements Provider
{
    private $providers = array();

    public function add(Provider $provider)
    {
        $this->providers[] = $provider;
    }

    public function populate(Sitemap $sitemap)
    {
        $map = function (Provider $provider) use ($sitemap)
        {
            $provider->populate($sitemap);
        };

        array_map($map, $this->providers);
    }
}
