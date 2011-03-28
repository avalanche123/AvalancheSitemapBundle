<?php

namespace Avalanche\Bundle\SitemapBundle\Sitemap;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Avalanche\Bundle\SitemapBundle\Locatable;
use Avalanche\Bundle\SitemapBundle\Sitemap\Url\Image;

class Url implements Locatable
{
    private $id;
    private $loc;
    private $lastmod;
    private $changefreq;
    private $priority;
    private $images;

    const ALWAYS = 'always';
    const HOURLY = 'hourly';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const NEVER = 'never';

    public function __construct($loc, \DateTime $lastmod = null, $changefreq = null, $priority = null, Collection $images = null)
    {
        $this->loc        = $loc;
        $this->lastmod    = $lastmod ? $lastmod : new \DateTime();
        $this->changefreq = $changefreq;
        $this->priority   = $priority;
        $this->images     = $images ? $images : new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLoc()
    {
        return $this->loc;
    }

    public function setLastmod(\DateTime $lastmod)
    {
        $this->lastmod = $lastmod;
    }

    public function getLastmod()
    {
        return $this->lastmod;
    }

    public function setChangefreq($changefreq)
    {
        $this->changefreq = $changefreq;
    }

    public function getChangefreq()
    {
        return $this->changefreq;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function add(Image $image)
    {
        $this->images->add($image);
    }

    public function remove(Image $image)
    {
        $this->images->removeElement($image);
    }

    public function all()
    {
        return $this->images;
    }

    public function clear()
    {
        $this->images->clear();
    }
}
