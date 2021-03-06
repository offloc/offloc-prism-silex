<?php

/**
 * This file is a part of offloc/prism-silex.
 *
 * (c) Offloc Incorporated
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Offloc\Prism\Silex\App\Api\Controller;

use Offloc\Prism\Domain\Model\Route\Route;
use Offloc\Prism\Domain\Model\Service\Service;
use Offloc\Prism\Silex\App\Api\Api;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines the abstract API Controller
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
abstract class AbstractController
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Constructor
     *
     * @param Application $app Silex application
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    protected function authenticate(Request $request)
    {
        return $this->app['offloc.prism.requestAuthenticator']->authenticate($request);
    }

    protected function requireAuthentication(Request $request)
    {
        $service = $this->authenticate($request);

        if (null === $service) {
            throw new \Exception("Authentication required");
        }

        if (!$service->active()) {
            throw new \Exception("Authentication required, authenticated service is inactive");
        }

        return $service;
    }

    protected function generateUrl($name, array $parameters = array(), $absolute = false)
    {
        return $this->app['url_generator']->generate($name, $parameters, $absolute);
    }

    protected function generateRouteUrl(Route $route)
    {
        return $this->generateUrl(Api::ROUTE_ROUTE_DETAIL, array('routeId' => $route->id()), true);
    }

    protected function generateServiceUrl(Service $service)
    {
        return $this->generateUrl(Api::ROUTE_SERVICE_DETAIL, array('serviceKey' => $service->key(), ), true);
    }

    protected function session()
    {
        return $this->app['offloc.prism.domain.model.session'];
    }

    protected function routeFactory()
    {
        return $this->app['offloc.prism.domain.model.route.routeFactory'];
    }

    protected function routeRepository()
    {
        return $this->app['offloc.prism.domain.model.route.routeRepository'];
    }

    protected function serviceRepository()
    {
        return $this->app['offloc.prism.domain.model.service.serviceRepository'];
    }

}
