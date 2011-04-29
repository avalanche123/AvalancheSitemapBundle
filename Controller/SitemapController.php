<?php

namespace Avalanche\Bundle\SitemapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Avalanche\Bundle\SitemapBundle\Sitemap;

class SitemapController
{
    private $sitemap;
    private $templating;
    private $request;

    public function __construct(Sitemap $sitemap, EngineInterface $templating, Request $request)
    {
        $this->sitemap    = $sitemap;
        $this->templating = $templating;
        $this->request    = $request;
    }

    public function sitemap()
    {
        $page = $this->request->query->get('page', 1);

        $this->sitemap->setPage($page);

        return $this->templating->renderResponse('AvalancheSitemapBundle:Sitemap:sitemap.twig.xml', array(
            'sitemap' => $this->sitemap
        ));
    }

    public function siteindex()
    {
        return $this->templating->renderResponse('AvalancheSitemapBundle:Sitemap:siteindex.twig.xml', array(
            'pages'   => $this->sitemap->pages(),
            'sitemap' => $this->sitemap,
        ));
    }
}
