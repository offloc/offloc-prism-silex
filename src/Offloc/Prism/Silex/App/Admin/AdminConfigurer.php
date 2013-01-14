<?php

/**
 * This file is a part of offloc/prism-silex.
 *
 * (c) Offloc Incorporated
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Offloc\Prism\Silex\App\Admin;

use Silex\Application;

/**
 * Admin Configurer
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class AdminConfigurer
{
    public static function configure(Application $app)
    {
        $app->register(new \Silex\Provider\TwigServiceProvider, array(
            'twig.path' => array(
                __DIR__ . '/Resources/views',
            ),
        ));

        $app->register(new \Silex\Provider\SessionServiceProvider);
        $app->register(new \Silex\Provider\SecurityServiceProvider);

        $app->register(new AdminServiceProvider);
    }
}
