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
        foreach ($this->providers as $provider) {
            $provider->populate($sitemap);
        }
    }
}
