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

use Dflydev\IdentityGenerator\DataStore\Dbal\DataStore;
use Dflydev\IdentityGenerator\Generator\Base32CrockfordGenerator;
use Dflydev\IdentityGenerator\Generator\RandomNumberGenerator;
use Dflydev\IdentityGenerator\Generator\RandomStringGenerator;
use Dflydev\IdentityGenerator\IdentityGenerator;
use Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Offloc\Prism\Domain\Model\Route\RouteFactory;
use Offloc\Prism\Domain\Model\Service\ServiceFactory;
use Offloc\Prism\Domain\Service\DflydevIdentityGeneratorService;
use Offloc\Prism\Domain\Service\UuidSecretGeneratorService;
use Offloc\Prism\Infrastructure\Persistence\Doctrine\Route\RouteRepository;
use Offloc\Prism\Infrastructure\Persistence\Doctrine\Service\ServiceRepository;
use Offloc\Prism\Infrastructure\Persistence\Doctrine\Session;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * API Service Provider
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ApiServiceProvider implements ServiceProviderInterface
{
    public function boot(Application $app)
    {
    }

    public function register(Application $app)
    {
        $app['resolver'] = $app->share($app->extend('resolver', function ($resolver, $app) {
            return new \Offloc\Prism\Silex\ServiceControllerResolver($resolver, $app);
        }));

        $app['offloc.prism.webapp.api.controller.rootController'] = $app->share(function() use ($app) {
            return new Controller\RootController($app);
        });

        $app['offloc.prism.webapp.api.controller.authController'] = $app->share(function() use ($app) {
            return new Controller\AuthController($app);
        });

        $app['offloc.prism.webapp.api.controller.routeController'] = $app->share(function() use ($app) {
            return new Controller\RouteController($app);
        });

        $app['offloc.prism.webapp.api.controller.serviceController'] = $app->share(function() use ($app) {
            return new Controller\ServiceController($app);
        });

        $app->get('/', 'offloc.prism.webapp.api.controller.rootController:rootAction')->bind(Api::ROUTE_ROOT);

        $app->get('/auth', 'offloc.prism.webapp.api.controller.authController:rootAction')
            ->bind(Api::ROUTE_AUTH_ROOT);

        $app->post('/auth/authenticate', 'offloc.prism.webapp.api.controller.authController:authenticateAction')
            ->bind(Api::ROUTE_AUTH_AUTHENTICATE);

        $app->get('/route', 'offloc.prism.webapp.api.controller.routeController:rootAction')
            ->bind(Api::ROUTE_ROUTE_ROOT);

        $app->post('/route/routes', 'offloc.prism.webapp.api.controller.routeController:createAction')
            ->bind(Api::ROUTE_ROUTE_CREATE);

        $app->post('/route/find', 'offloc.prism.webapp.api.controller.routeController:findAction')
            ->bind(Api::ROUTE_ROUTE_FIND);

        $app->get('/route/routes/{routeId}', 'offloc.prism.webapp.api.controller.routeController:detailAction')
            ->bind(Api::ROUTE_ROUTE_DETAIL);

        $app->get('/service', 'offloc.prism.webapp.api.controller.serviceController:rootAction')
            ->bind(Api::ROUTE_SERVICE_ROOT);

        $app->post('/service/services', 'offloc.prism.webapp.api.controller.serviceController:createAction')
            ->bind(Api::ROUTE_SERVICE_CREATE);

        $app->post('/service/find', 'offloc.prism.webapp.api.controller.serviceController:findAction')
            ->bind(Api::ROUTE_SERVICE_FIND);

        $app->get('/service/services/{serviceKey}', 'offloc.prism.webapp.api.controller.serviceController:detailAction')
            ->bind(Api::ROUTE_SERVICE_DETAIL);
    }
}
