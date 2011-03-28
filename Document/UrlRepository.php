<?php

namespace Avalanche\Bundle\SitemapBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Avalanche\Bundle\SitemapBundle\Sitemap\Url;
use Avalanche\Bundle\SitemapBundle\Sitemap\UrlRepositoryInterface;

class UrlRepository extends DocumentRepository implements UrlRepositoryInterface
{
    private $urlsToRemove = array();

    public function add(Url $url)
    {
        $this->dm->persist($url);
        $this->scheduleForCleanup($url);
    }

    public function findAllOnPage($page)
    {
        return $this->createQueryBuilder()
            ->skip(UrlRepositoryInterface::PER_PAGE_LIMIT * ($page - 1))
            ->limit(UrlRepositoryInterface::PER_PAGE_LIMIT)
            ->hydrate(false)
            ->getQuery()
            ->execute();
    }

    public function findOneByLoc($loc)
    {
        $url = $this->findOneBy(array('loc' => $loc));
        if (null !== $url) {
            $this->scheduleForCleanup($url);
        }
        return $url;
    }

    public function remove(Url $url)
    {
        $this->dm->remove($url);
        $this->scheduleForCleanup($url);
    }

    public function pages()
    {
        return max(ceil(count($this->findAll()) / UrlRepositoryInterface::PER_PAGE_LIMIT), 1);
    }

    public function flush()
    {
        $this->dm->flush(array('safe' => true));
        $this->cleanup();
    }

    public function getLastmod($page)
    {
    }

    private function scheduleForCleanup(Url $url)
    {
        $this->urlsToRemove[] = $url;
    }

    private function cleanup()
    {
        foreach ($this->urlsToRemove as $url) {
            $this->dm->detach($url);
        }
        $this->urlsToRemove = array();
    }
}
