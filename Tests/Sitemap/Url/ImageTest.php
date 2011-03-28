<?php

namespace Avalanche\Bundle\SitemapBundle\Tests\Sitemap\Url;

use Avalanche\Bundle\SitemapBundle\Sitemap\Url\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldInitializeImageProperly()
    {
        $loc         = 'http://www.google.com/logo.jpg';
        $caption     = 'Logo';
        $geoLocation = 'Somewhere. Somestate';
        $title       = 'Google Logo';
        $license     = 'http://creativecommons.org/licenses/by-nc-sa/3.0/';

        $image = new Image($loc);

        $this->assertEquals($loc, $image->getLoc());
        $this->assertNull($image->getCaption());
        $this->assertNull($image->getGeoLocation());
        $this->assertNull($image->getTitle());
        $this->assertNull($image->getLicense());

        $image->setCaption($caption);
        $image->setGeoLocation($geoLocation);
        $image->setTitle($title);
        $image->setLicense($license);

        $this->assertEquals($caption, $image->getCaption());
        $this->assertEquals($geoLocation, $image->getGeoLocation());
        $this->assertEquals($title, $image->getTitle());
        $this->assertEquals($license, $image->getLicense());

        $image = new Image($loc, $caption, $geoLocation, $title, $license);

        $this->assertEquals($caption, $image->getCaption());
        $this->assertEquals($geoLocation, $image->getGeoLocation());
        $this->assertEquals($title, $image->getTitle());
        $this->assertEquals($license, $image->getLicense());
    }
}
