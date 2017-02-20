<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

namespace Zetta\ZendMPDF;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ServiceManager\Proxy\LazyServiceFactory;
use Zetta\ZendMPDF\View\Strategy\MpdfStrategy;

class ConfigProvider implements ConfigProviderInterface
{
    /**
     * Return configuration for this component.
     *
     * @return array
     */
    public function __invoke()
    {
        return $this->getConfig();
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return [
            'service_manager' => $this->getServiceManager(),
            'view_manager' => $this->getViewManagerConfig()
        ];
    }

    /**
     * Return component helpers configuration.
     *
     * @return array
     */
    public function getServiceManager()
    {
        return [
            'factories' => [
                Service\MpdfService::class => Service\MpdfService::class,
                View\Renderer\MpdfRenderer::class => View\Renderer\MpdfRendererFactory::class,
                View\Strategy\MpdfStrategy::class => View\Strategy\MpdfStrategyFactory::class,
            ],
            'lazy_services' => [
                'class_map' => [
                    View\Renderer\MpdfRenderer::class => View\Renderer\MpdfRenderer::class,
                ],
                'proxies_target_dir' => 'data/Proxy',
                'write_proxy_files' => true
            ],
            'delegators' => [
                View\Renderer\MpdfRenderer::class => [
                    LazyServiceFactory::class
                ]
            ],
            'shared' => [
                Service\MpdfService::class => false
            ],
        ];
    }

    /**
     * Return component helpers configuration.
     *
     * @return array
     */
    public function getViewManagerConfig()
    {
        return [
            'strategies' => [
                MpdfStrategy::class
            ]
        ];
    }
}
