<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

declare(strict_types=1);

namespace Zetta\ZendMPDF\View\Renderer;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Renderer\RendererInterface;
use Laminas\View\Resolver\ResolverInterface;
use Zetta\ZendMPDF\Service\MpdfService;

class MpdfRendererFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ResolverInterface $viewResolver */
        $viewResolver = $container->get('ViewResolver');
        /** @var RendererInterface $viewRenderer */
        $viewRenderer = $container->get('ViewRenderer');

        $mpdfRenderer = new MpdfRenderer();
        $mpdfRenderer->setResolver($viewResolver);
        $mpdfRenderer->setHtmlRenderer($viewRenderer);
        $mpdfRenderer->setMpdf($container->get(MpdfService::class));

        return $mpdfRenderer;
    }
}
