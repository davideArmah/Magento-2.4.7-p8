<?php
declare(strict_types=1);

namespace Armah\Base\Plugin\Framework\App\Router;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\App\RouterInterface;

class RedirectOldRoutes
{
    private const ROUTE_REDIRECTS = [
        'amblog' => 'armahblog',
        'arhshopby' => 'armahshopby',
        'amlocator' => 'armahlocator',
        'amsitemap' => 'armahsitemap',
        'arrewards' => 'armahrewards',
        'ammostviewed' => 'armahmostviewed',
        'amga4' => 'armahga4',
        'amcapthca' => 'armahcaptcha',
        'amcustomerattr' => 'armahcustomerattr',
        'amfile' => 'armahfile',
        'amoptimizer' => 'armahoptimizer',
        'amsociallogin' => 'armahsociallogin',
    ];

    private $response;
    private $actionFactory;

    public function __construct(HttpResponse $response, ActionFactory $actionFactory)
    {
        $this->response = $response;
        $this->actionFactory = $actionFactory;
    }

    public function aroundMatch(RouterInterface $subject, callable $proceed, RequestInterface $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        $parts = explode('/', $pathInfo);

        if (empty($parts[0])) {
            return $proceed($request);
        }

        if (isset(self::ROUTE_REDIRECTS[$parts[0]])) {
            $parts[0] = self::ROUTE_REDIRECTS[$parts[0]];
            $newPath = '/' . implode('/', $parts);

            $queryString = $request->getServer('QUERY_STRING');
            if ($queryString) {
                $newPath .= '?' . $queryString;
            }

            $this->response->setRedirect($newPath, 301);
            $this->response->sendResponse();
            return $this->actionFactory->create(Forward::class);
        }

        return $proceed($request);
    }
}
