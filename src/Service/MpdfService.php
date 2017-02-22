<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

namespace Zetta\ZendMPDF\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use mPDF;

class MpdfService implements FactoryInterface
{

    const MPDF_DIR = 'data/mpdf/';
    const TEMP_DIR = self::MPDF_DIR . 'temp/';
    const TTFONTDATA_DIR = self::MPDF_DIR . 'ttfontdata/';
    const JPGRAPH_DIR = self::MPDF_DIR . 'jpgraph/';

    /**
     * {@inheritdoc}
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

        define("_MPDF_TEMP_PATH", MpdfService::TEMP_DIR);
        define("_MPDF_TTFONTDATAPATH", MpdfService::TTFONTDATA_DIR);
        define("_JPGRAPH_PATH", MpdfService::JPGRAPH_DIR);

        return new mPDF();
    }
}