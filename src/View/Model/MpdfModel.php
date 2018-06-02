<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

namespace Zetta\ZendMPDF\View\Model;

use Zend\View\Model\ViewModel;

class MpdfModel extends ViewModel
{
    /**
     * O PDF é enviado como um anexo para ser visualizado
     */
    const DESTINO_INLINE_NAVEGADOR = 'I';
    /**
     * O PDF é enviado como um anexo para ser baixado pelo navegador
     */
    const DESTINO_DOWNLOAD_NAVEGADOR = 'D';
    /**
     * O arquivo é salvo no sistema de arquivo do servidor
     */
    const DESTINO_SALVAR_EM_ARQUIVO = 'F';
    /**
     * Retorna o documento como string.
     */
    const DESTINO_RETORNAR_COMO_STRING = 'S';

    /**
     * @var array
     */
    protected $options = [
        'paperSize' => 'A4',
        'paperOrientation' => 'portrait',
        'basePath' => '/',
        'filename' => 'filename.pdf',
        'destination' => self::DESTINO_DOWNLOAD_NAVEGADOR,
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
