<?php

/**
 * This file is a part of offloc/prism-silex.
 *
 * (c) Offloc Incorporated
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Offloc\Prism\Silex\App\Api;

use Silex\Application;

/**
 * API Configurer
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ApiConfigurer
{
    public static function configure(Application $app)
    {
        $app->register(new ApiServiceProvider);
    }
}
