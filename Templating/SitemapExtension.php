<?php

namespace Avalanche\Bundle\SitemapBundle\Templating;

use InvalidArgumentException;

class SitemapExtension extends \Twig_Extension
{
    private $baseUrl;
    private $scheme;

    public function __construct($baseUrl)
    {
        $this->baseUrl = trim($baseUrl, '/');
        $this->scheme = preg_replace('#^(\w+)://.+$#', '$1', $baseUrl);

        if(!in_array($this->scheme, $this->getKnownSchemes())) {
            throw new InvalidArgumentException(sprintf('Base url "%s" does not have a valid scheme', $baseUrl));
        }
    }

    public function getFilters()
    {
        return array(
            'sm_absolutize' => new \Twig_Filter_Method($this, 'getAbsoluteUrl'),
            'sm_format_date' => new \Twig_Filter_Method($this, 'getFormattedDate'),
        );

        return parent::getFilters();
    }

    public function getAbsoluteUrl($path)
    {
        if (0 !== strpos($path, '/')) {
            return $path;
        }
        if ('//' === substr($path, 0, 2)) {
            return $this->scheme.':'.$path;
        }
        return $this->baseUrl.$path;
    }

    public function getFormattedDate($date)
    {
        if ($date instanceof \MongoDate) {
            return date('Y-m-d', $date->sec);
        }
        if ($date instanceof \DateTime) {
            return $date->format('Y-m-d');
        }
    }

    private function getKnownSchemes()
    {
        return array('http', 'https');
    }

    public function getName()
    {
        return 'sitemap';
    }
}
