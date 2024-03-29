<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

declare(strict_types=1);

namespace Zetta\ZendMPDF;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ServiceManager\Proxy\LazyServiceFactory;
use Traversable;

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
     * @return array|Traversable
     */
    public function getConfig()
    {
        return [
            'service_manager' => $this->getServiceManager(),
            'view_manager' => $this->getViewManagerConfig(),
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
                View\Strategy\MpdfStrategy::class => Factory\WithMpdfRendererFactory::class,
            ],
            'lazy_services' => [
                'class_map' => [
                    View\Renderer\MpdfRenderer::class => View\Renderer\MpdfRenderer::class,
                ],
            ],
            'delegators' => [
                View\Renderer\MpdfRenderer::class => [
                    LazyServiceFactory::class,
                ],
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
                View\Strategy\MpdfStrategy::class,
            ],
        ];
    }
}
