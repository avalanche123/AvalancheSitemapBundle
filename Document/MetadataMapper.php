<?php

namespace Avalanche\Bundle\SitemapBundle\Document;

use Doctrine\ODM\MongoDB\Event\LoadClassMetadataEventArgs;

class MetadataMapper
{
    private $collection;
    private $database;
    private $urlClass;

    public function __construct($collection, $database, $urlClass)
    {
        $this->collection = $collection;
        $this->database   = $database;
        $this->urlClass   = $urlClass;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $metadata = $args->getClassMetadata();

        if ($this->urlClass !== $metadata->name) {
            return;
        }

        $metadata->db         = $this->database;
        $metadata->collection = $this->collection;
    }
}
