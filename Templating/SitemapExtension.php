<?php

namespace Bundle\Avalanche\SitemapBundle\Templating;

use Symfony\Component\HttpFoundation\Request;

class SitemapExtension extends \Twig_Extension
{
    private $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function getFilters()
    {
        if (isset($this->request)) {
            return array(
                'sm_absolutize' => new \Twig_Filter_Method($this, 'getAbsoluteUrl'),
                'sm_format_date' => new \Twig_Filter_Method($this, 'getFormattedDate'),
            );
        }

        return parent::getFilters();
    }

    public function getAbsoluteUrl($path)
    {
        if (0 !== strpos($path, '/')) {
            return $path;
        }
        if ('//' === substr($path, 0, 2)) {
            return $this->request->getScheme().':'.$path;
        }
        return $this->request->getUriForPath($path);
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

    public function getName()
    {
        return 'sitemap';
    }
}
