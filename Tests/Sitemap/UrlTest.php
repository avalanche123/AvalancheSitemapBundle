<?php

namespace Avalanche\Bundle\SitemapBundle\Tests\Sitemap;

use Avalanche\Bundle\SitemapBundle\Sitemap\Url\Image;

use Avalanche\Bundle\SitemapBundle\Sitemap\Url;

use Doctrine\Common\Collections\ArrayCollection;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldInitializeUrlWithData()
    {
        $loc        = 'http://www.google.com';
        $lastmod    = \DateTime::createFromFormat('Y-m-d', '2011-10-10');
        $changefreq = 'monthly';
        $priority   = '2';
        $images     = new ArrayCollection();

        $url = new Url($loc);

        $this->assertEquals($loc, $url->getLoc());
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $url->all());
        $this->assertEquals(0, count($url->all()));
        $this->assertInstanceOf('DateTime', $url->getLastmod());
        $this->assertNull($url->getChangefreq());
        $this->assertNull($url->getPriority());

        $url->setLastmod($lastmod);
        $url->setChangefreq($changefreq);
        $url->setPriority($priority);

        $this->assertEquals($lastmod, $url->getLastmod());
        $this->assertEquals($changefreq, $url->getChangefreq());
        $this->assertEquals($priority, $url->getPriority());

        $url = new Url($loc, $lastmod, $changefreq, $priority, $images);

        $this->assertEquals($loc, $url->getLoc());
        $this->assertEquals($lastmod, $url->getLastmod());
        $this->assertEquals($changefreq, $url->getChangefreq());
        $this->assertEquals($priority, $url->getPriority());
        $this->assertSame($images, $url->all());

        $image = new Image($loc.'/logo.jpg');

        $url->add($image);

        $this->assertEquals(1, count($url->all()));

        $url->remove($image);

        $this->assertEquals(0, count($url->all()));
    }
}