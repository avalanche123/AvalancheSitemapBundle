<?php

namespace Avalanche\Bundle\SitemapBundle\Sitemap\Url;

use Avalanche\Bundle\SitemapBundle\Locatable;

class Image implements Locatable
{
    private $loc;
    private $caption;
    private $geoLocation;
    private $title;
    private $license;

    public function __construct($loc, $caption = null, $geoLocation = null, $title = null, $license = null)
    {
        $this->loc = $loc;
        $this->caption = $caption;
        $this->geoLocation = $geoLocation;
        $this->title = $title;
        $this->license = $license;
    }

    public function getLoc()
    {
        return $this->loc;
    }

    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function setGeoLocation($geoLocation)
    {
        $this->geoLocation = $geoLocation;
    }

    public function getGeoLocation()
    {
        return $this->geoLocation;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setLicense($license)
    {
        $this->license = $license;
    }

    public function getLicense()
    {
        return $this->license;
    }
}
