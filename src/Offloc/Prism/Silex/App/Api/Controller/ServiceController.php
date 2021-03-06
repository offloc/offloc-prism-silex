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

use Offloc\Prism\Api\Common\Message;
use Offloc\Prism\Silex\App\Api\Api;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines the Service API Controller
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ServiceController extends AbstractController
{
    /**
     * Root action
     *
     * @return string
     */
    public function rootAction()
    {
        return $this->app->json(array(
            'type' => Message::TYPE_SERVICE_ROOT,
            'create' => $this->generateUrl(Api::ROUTE_SERVICE_CREATE, array(), true),
            'find' => $this->generateUrl(Api::ROUTE_SERVICE_FIND, array(), true),
        ));
    }

    /**
     * Find action
     *
     * @param Request $request Request
     *
     * @return string
     */
    public function findAction(Request $request)
    {
        $service = $this->serviceRepository()->find($request->request->get('key'));

        $serviceLink = $this->generateServiceUrl($service);

        return $this->app->json(array(
            'type' => Message::TYPE_SERVICE_LINK,
            'link' => $serviceLink,
        ), 303, array('Location' => $serviceLink,));
    }

    /**
     * Detail action
     *
     * @param Request $request    Request
     * @param string  $serviceKey Service key
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function detailAction(Request $request, $serviceKey)
    {
        $authenticatedService = $this->requireAuthentication($request);
        $service = $this->serviceRepository()->find($serviceKey);

        return $this->app->json(array(
            'type' => Message::TYPE_SERVICE_DETAIL,
            'link' => $this->generateServiceUrl($service),
            'key' => $service->key(),
            'name' => $service->name(),
            'url' => $service->url(),
            'secret' => $authenticatedService->canAdmin($service) ? $service->secret() : null,
        ));
    }
}
