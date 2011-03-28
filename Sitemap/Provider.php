<?php

namespace Avalanche\Bundle\SitemapBundle\Sitemap;

use Avalanche\Bundle\SitemapBundle\Sitemap;

interface Provider
{
    function populate(Sitemap $sitemap);
}
