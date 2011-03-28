<?php

namespace Avalanche\Bundle\SitemapBundle\Tests;

use Avalanche\Bundle\SitemapBundle\Sitemap;
use Avalanche\Bundle\SitemapBundle\Sitemap\Url;

class SitemapTest extends \PHPUnit_Framework_TestCase
{
    private $repository;
    private $sitemap;

    protected function setUp()
    {
        $this->repository = $this->getMockUrlRepository();
        $this->sitemap    = new Sitemap($this->repository);
    }

    public function testShouldSetGetPage()
    {
        $this->assertEquals(1, $this->sitemap->getPage());

        $page = 2;

        $this->sitemap->setPage($page);

        $this->assertEquals($page, $this->sitemap->getPage());
    }

    public function testShouldSaveUrlInRepository()
    {
        $url = new Url('http://www.google.com');

        $this->repository->expects($this->once())
            ->method('add')
            ->with($url);

        $this->sitemap->add($url);
    }

    public function testShouldRetrieveFromRepository()
    {
        $loc = 'http://www.google.com';
        $url = new Url($loc);

        $this->repository->expects($this->once())
            ->method('findOneByLoc')
            ->with($loc)
            ->will($this->returnValue($url));

        $this->assertSame($url, $this->sitemap->get($loc));
    }

    public function testShouldDeleteFromRepository()
    {
        $url = new Url('http://www.google.com');

        $this->repository->expects($this->once())
            ->method('remove')
            ->with($url);

        $this->sitemap->remove($url);
    }

    public function testShouldFindCorrectPage()
    {
        $page = 1;

        $this->sitemap->setPage($page);

        $this->repository->expects($this->once())
            ->method('findAllOnPage')
            ->with($page)
            ->will($this->returnValue(array()));

        $this->assertEquals(0, count($this->sitemap->all()));
    }

    private function getMockUrlRepository()
    {
        return $this->getMock('Avalanche\Bundle\SitemapBundle\Sitemap\UrlRepositoryInterface');
    }
}
