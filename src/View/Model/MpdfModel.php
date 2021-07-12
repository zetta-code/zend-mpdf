<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

declare(strict_types=1);

namespace Zetta\ZendMPDF\View\Model;

use Laminas\View\Model\ViewModel;

class MpdfModel extends ViewModel
{
    /**
     * O PDF é enviado como um anexo para ser visualizado
     */
    const DESTINATION_INLINE_BROWSER = 'I';
    /**
     * O PDF é enviado como um anexo para ser baixado pelo navegador
     */
    const DESTINATION_DOWNLOAD_BROWSER = 'D';
    /**
     * O arquivo é salvo no sistema de arquivo do servidor
     */
    const DESTINATION_OUTPUT_FILE = 'F';
    /**
     * Retorna o documento como string.
     */
    const DESTINATION_OUTPUT_STRING = 'S';

    /**
     * @var array
     */
    protected $options = [
        'paperSize' => 'A4',
        'paperOrientation' => 'portrait',
        'basePath' => '/',
        'filename' => 'filename.pdf',
        'destination' => self::DESTINATION_DOWNLOAD_BROWSER,
        'debug' => false,
    ];

    /**
     *
     * @var string
     */
    protected $captureTo = null;

    /**
     * @var bool
     */
    protected $terminate = true;
}
