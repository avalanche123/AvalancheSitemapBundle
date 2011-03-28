<?php

namespace Avalanche\Bundle\SitemapBundle;

use Avalanche\Bundle\SitemapBundle\Sitemap\Url;
use Avalanche\Bundle\SitemapBundle\Sitemap\UrlRepositoryInterface;

class Sitemap
{
    private $repository;
    private $page;

    public function __construct(UrlRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->page       = 1;
    }

    public function add(Url $url)
    {
        $this->repository->add($url);
    }

    public function remove(Url $url)
    {
        return $this->repository->remove($url);
    }

    public function all()
    {
        return $this->repository->findAllOnPage($this->page);
    }

    public function get($loc)
    {
        return $this->repository->findOneByLoc($loc);
    }

    public function pages()
    {
        return $this->repository->pages();
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function save()
    {
        $this->repository->flush();
    }

    public function lastmod($page)
    {
        return $this->repository->getLastmod($page);
    }
}
