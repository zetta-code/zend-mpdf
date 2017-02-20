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
        // Foi necessario incluir o arquivo mpdf.php porque estava dando erro ao usar o lazy proxy.
        //require_once __DIR__ . '/../../../../../../vendor/mpdf/mpdf/mpdf.php';

        $mpdfRenderer = $container->get(MpdfRenderer::class);
        $mpdfStrategy = new MpdfStrategy($mpdfRenderer);

        return $mpdfStrategy;
    }
}
