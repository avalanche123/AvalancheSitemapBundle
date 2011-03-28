<?php

namespace Avalanche\Bundle\SitemapBundle\Templating;

use PHPUnit_Framework_TestCase;

class SitemapExtensionText extends PHPUnit_Framework_TestCase
{
    protected $baseUrl = 'http://sitemaps.org/';

    protected function getExtension()
    {
        return new SitemapExtension($this->baseUrl);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInstanciateExtensionWithoutProperBaseUrlTrowsAnException()
    {
        new SitemapExtension('/invalid/url');
    }

    public function testGetAbsoluteUrlDoNotModifyAbsoluteUrl()
    {
        $url = 'http://site.org/url';
        $this->assertEquals($url, $this->getExtension()->getAbsoluteUrl($url));
    }

    public function testGetAbsoluteUrlPrependsBaseUrlToRelativePath()
    {
        $path = '/some/path';
        $expected = 'http://sitemaps.org/some/path';
        $this->assertEquals($expected, $this->getExtension()->getAbsoluteUrl($path));
    }

    public function testGetAbsoluteUrlPrependsSchemeToDoubleSlashPath()
    {
        $path = '//site.org/some/path';
        $expected = 'http://site.org/some/path';
        $this->assertEquals($expected, $this->getExtension()->getAbsoluteUrl($path));
    }
}
