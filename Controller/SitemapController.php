<?php

namespace Bundle\Avalanche\SitemapBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\Engine;
use Bundle\Avalanche\SitemapBundle\Sitemap;

class SitemapController
{
    private $sitemap;
    private $templating;
    private $request;

    public function __construct(Sitemap $sitemap, Engine $templating, Request $request)
    {
        $this->sitemap    = $sitemap;
        $this->templating = $templating;
        $this->request    = $request;
    }

    public function sitemap()
    {
        $page = $this->request->query->get('page', 1);

        $this->sitemap->setPage($page);

        return $this->templating->renderResponse('SitemapBundle:Sitemap:sitemap.xml.twig', array(
            'sitemap' => $this->sitemap
        ));
    }

    public function siteindex()
    {
        return $this->templating->renderResponse('SitemapBundle:Sitemap:siteindex.xml.twig', array(
            'pages' => $this->sitemap->pages()
        ));
    }
}
