<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

namespace Zetta\ZendMPDF\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use mPDF;

class MpdfService implements FactoryInterface
{

    const MPDF_DIR = 'data/mpdf/';
    const TEMP_DIR = self::MPDF_DIR . 'temp/';
    const TTFONTDATA_DIR = self::MPDF_DIR . 'ttfontdata/';
    const JPGRAPH_DIR = self::MPDF_DIR . 'jpgraph/';

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (!file_exists(self::MPDF_DIR)) {
            mkdir(self::MPDF_DIR, 0777, true);
        }
        if (!file_exists(self::TEMP_DIR)) {
            mkdir(self::TEMP_DIR, 0777, true);
        }
        if (!file_exists(self::TTFONTDATA_DIR)) {
            mkdir(self::TTFONTDATA_DIR, 0777, true);
        }
        if (!file_exists(self::JPGRAPH_DIR)) {
            mkdir(self::JPGRAPH_DIR, 0777, true);
        }

        return new mPDF();
    }
}