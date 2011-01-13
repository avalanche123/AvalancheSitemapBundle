<?php

namespace Bundle\Avalanche\SitemapBundle\Sitemap;

use Bundle\Avalanche\SitemapBundle\Sitemap;

interface Provider
{
    function populate(Sitemap $sitemap);
}
