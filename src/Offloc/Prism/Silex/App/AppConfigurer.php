<?php

/**
 * This file is a part of offloc/prism-silex.
 *
 * (c) Offloc Incorporated
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Offloc\Prism\Silex\App;

use Silex\Application;

/**
 * Application Configurer
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class AppConfigurer
{
    public static function configure(Application $app)
    {
        $app->register(new \Igorw\Silex\ConfigServiceProvider(
            $app['offloc.prism.projectRoot']."/config/".$app['env'].".json"
        ));
        $app->register(new \Dflydev\Silex\Provider\Psr0ResourceLocator\Psr0ResourceLocatorServiceProvider);
        $app->register(new \Dflydev\Silex\Provider\Psr0ResourceLocator\Composer\ComposerResourceLocatorServiceProvider);
        $app->register(new \Silex\Provider\UrlGeneratorServiceProvider);
        $app->register(new \Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider);
        $app->register(new \Silex\Provider\DoctrineServiceProvider);
        $app->register(new \Offloc\Prism\Silex\Provider\Domain\DomainServiceProvider);
    }
}
