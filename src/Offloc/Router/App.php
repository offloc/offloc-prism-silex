<?php

/**
 * This file is a part of offloc/router-silex-app.
 *
 * (c) Offloc Incorporated
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Offloc\Router;

use Silex\Application;

/**
 * App
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class App extends Application
{
    /**
     * Constructor
     *
     * @param string $env   Environment
     * @param bool   $debug Debug?
     */
    public function __construct($env = 'prod', $debug = false)
    {
        parent::__construct();

        $this['env'] = $env;
        $this['debug'] = $debug;

        $this->configure();
    }

    protected function configure()
    {
        $projectRoot = __DIR__.'/../../..';

        $this->register(new \Silex\Provider\UrlGeneratorServiceProvider);

        $this->register(new \Silex\Provider\TwigServiceProvider, array(
            'twig.path' => $projectRoot . '/views',
        ));
    }
}