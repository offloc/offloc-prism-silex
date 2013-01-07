<?php

/**
 * This file is a part of offloc/prism-silex-app.
 *
 * (c) Offloc Incorporated
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Offloc\Prism\WebApp;

/**
 * Web App
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class Web extends AbstractApp
{
    protected function configure()
    {
        parent::configure();

        $app = $this;
    }
}