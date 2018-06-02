<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

namespace Zetta\ZendMPDF\View\Strategy;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zetta\ZendMPDF\View\Renderer\MpdfRenderer;

class MpdfStrategyFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $mpdfRenderer = $container->get(MpdfRenderer::class);
        $mpdfStrategy = new MpdfStrategy($mpdfRenderer);

        return $mpdfStrategy;
    }
}
