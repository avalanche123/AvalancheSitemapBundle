<?php

namespace Bundle\Avalanche\SitemapBundle\Service;

use Bundle\Avalanche\SitemapBundle\Sitemap;
use Bundle\Avalanche\SitemapBundle\Sitemap\Url;
use Bundle\Avalanche\SitemapBundle\Sitemap\Url\Image;
use Bundle\Avalanche\SitemapBundle\Sitemap\Provider;

class SitemapProvider implements Provider
{
    public function populate(Sitemap $sitemap)
    {
        for ($i=1; $i<=20000; $i++) {
            $url = new Url('/urls/'.$i);
            while((bool) round(rand(0, 2))) {
                $image = new Image('/urls/'.$i.'/images/'.microtime(true).'.jpg');
                $url->add($image);
            }
            $url->setLastmod(new \DateTime());
            $sitemap->add($url);
            if ($i % 200 == 0) {
                $sitemap->save();
            }
        }
    }
}
