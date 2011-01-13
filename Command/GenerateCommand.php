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
        $output->write('<info>Starting to iterate over sitemap providers</info>', true);
        foreach ($this->container->findTaggedServiceIds('sitemap.provider') as $id => $attributes) {
            $provider = $this->container->get($id);
            if ($provider instanceof Provider) {
                $output->write(sprintf("<info>Provider '%s' is starting to populate sitemap</info>\r", $id));
                $provider->populate($sitemap);
                $output->write(sprintf("<info>Provider '%s' finished populating sitemap</info>", $id), true);
            }
        }
        $sitemap->save();
        $output->write('', true);
        $output->write('<info>Sitemap was sucessfully saved!</info>', true);
    }
}
