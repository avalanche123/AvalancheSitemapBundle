<?php

namespace Avalanche\Bundle\SitemapBundle\Sitemap;

interface UrlRepositoryInterface
{
    const PER_PAGE_LIMIT = 10000;

    function findOneByLoc($loc);
    function findAllOnPage($page);
    function add(Url $url);
    function remove(Url $url);
    function pages();
    function flush();
    function getLastmod($page);
}