<?php

namespace Bundle\Avalanche\SitemapBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\Command;
use Bundle\Avalanche\SitemapBundle\Sitemap\Provider;

class GenerateCommand extends Command
{
    protected function configure()
    {
        $this->setName('sitemap:generate')
            ->setDescription('Generate sitemap, using its data providers.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $sitemap = $this->container->get('sitemap');

        $this->container->get('sitemap.provider.chain')->populate($sitemap);

        $sitemap->save();

        $output->write('<info>Sitemap was sucessfully saved!</info>', true);
    }
}
