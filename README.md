# Requirements

This SitemapBundle requires DoctrineMongoDBBundle enabled with default document
manager available.

In your doctrine mongodb odm bundle configuration add the following, in order to
register sitemap documents metadata:

    doctrine_odm.mongodb:
        # some odm configuration
        mappings:
            # other bundles mapping and etc.
            SitemapBundle:
                type: yml
                prefix: Bundle\Avalanche\SitemapBundle\Sitemap

# Installation as a submodule

The most common way to install a Bundle is by adding it as a submodule to your existing project. This setup will let you update the Bundle with ease in the future.

From the root directory of your Symfony2 application issue the following commands:
    $> mkdir src/Bundle/Avalanche
    $> git submodule add git://github.com/avalanche123/AvalancheSitemapBundle.git src/Bundle/Avalanche/SitemapBundle

# Adding bundle to Kernel

This bundle will help with sitemap generation in your Symfony2 based projects.
To enable the sitemap bundle, add it to you kernel registerBundles() method:

    use Symfony\Foundation\Kernel;

    class MyKernel extends Kernel {
        ...
        public function registerBundles() {
            return array(
                ...
                new Bundle\Avalanche\SitemapBundle\AvalancheSitemapBundle(),
                ...
            );
        }
        ...

        public function registerBundleDirs()
        {
            return array(
                ...
                'Bundle\\Avalanche' => __DIR__.'/../src/Bundle/Avalanche',
                ...
            );
        }
    }

# Unique indexes

Each entry in a sitemap (url or image) must have a unique loc attribute.
AvalancheSitemapBundle defines indexes in the doctrine odm metadata for url class.
To create them in your mongodb database, run the following command:

    $> app/console doctrine:mongodb:schema:create --index

# Enabling the services

The second step is to enable its DependencyInjection extension in your
config.yml:

    sitemap.config:
        base_url: "http://mywebsite.com/"

To store urls in a custom collection or database, use the following:

    sitemap.config:
        base_url: "http://mywebsite.com/"
        database: some_database
        collection: urls

By default 'sitemap' database will be used, with unique urls collection per
Kernel.

# Writing custom url providers for *sitemap:generate* command

The third step is to write your url providers to populate the 'sitemap' with
existing urls, e.g:

    <?php

    namespace My\ForumBundle\Sitemap;

    use Bundle\Avalanche\SitemapBundle\Sitemap\Provider;
    use Bundle\Avalanche\SitemapBundle\Sitemap\Sitemap;
    use Bundle\Avalanche\SitemapBundle\Sitemap\Sitemap\Url;
    use Bundle\Avalanche\SitemapBundle\Sitemap\Sitemap\Url\Image;
    use Symfony\Component\Routing\Router;
    use My\ForumBundle\Document\TopicRepository;

    class ForumTopicProvider implements SitemapProvider {

        protected $topicRepository;
        protected $router;

        public function __construct(TopicRepository $topicRepository, Router $router)
        {
            $this->topicRepository = $topicRepository;
            $this->router = $router;
        }

        public function populate(Sitemap $sitemap)
        {
            foreach ($this->topicRepository->find() as $topic) {
                $url = new Url($this->router->generate('topic_view', array('id' => $topic->getId()));
                $url->setLastmod($topic->getUpdateAt());
                $url->setChangefreq('daily');
                $url->setPriority('0.4');

                foreach ($topic->getAttachedImages() as $attachedImage) {
                    $image = new Image($this->router->generate('topic_image_view', array('id' => $attachedImage->getId())));
                    $image->setCaption($attachedImage->getCaption());
                    $image->setTitle($attachedImage->getTitle());
                    $image->setLicense('http://creativecommons.org/licenses/by/3.0/legalcode');

                    $url->add($image);
                }

                $sitemap->add($url);
            }

            $sitemap->save();
        }
    }

**NOTE:** in the above example, we use router to relative urls or paths. Upon
rendering, sitemap will figure out if the url is relative and will prefix it
with current base url. If you want your urls to belong to certain domain, that might be different from the one the sitemap will be available at, make sure to use absolute urls.

And register your provider in DIC like this:

    <service id="forum.sitemap.provider" class="My\ForumBundle\ForumTopicProvider">
        <tag name="sitemap.provider" />
        <argument type="service" id="forum.document_repository.topic" />
        <argument type="service" id="router" />
    </service>

After providers are in place and registered, time to run the generation command:

    > php forum/console sitemap:generate

or simply:

    > php forum/console sitemap:g

# Creating/Updating sitemap urls in the application

Creating/updating urls from web is as easy as from cli:

    $url = $this->sitemap->get('/topics/1');
    $url->setLastmod(new \DateTime());

    $this->sitemap->add(new Url('http://www.google.com'));

    $this->sitemap->save();

# Enabling sitemap routes

The last and most important step is to enable sitemap routing in your routing.yml:

    _sitemap:
      resource: SitemapBundle/Resources/config/routing.yml

After that is done, you can access your sitemap at /sitemap.xml and siteindex at /siteindex.xml

Happy Coding
