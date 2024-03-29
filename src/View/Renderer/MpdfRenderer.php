<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

declare(strict_types=1);

namespace Zetta\ZendMPDF\View\Renderer;

use ArrayAccess;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Renderer\RendererInterface;
use Laminas\View\Resolver\ResolverInterface;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class MpdfRenderer implements RendererInterface
{
    /**
     * @var Mpdf
     */
    protected $mpdf = null;

    /**
     * @var null
     */
    protected $resolver = null;

    /**
     * @var RendererInterface
     */
    protected $htmlRenderer = null;

    /**
     * @var string
     */
    protected $paperSize;

    /**
     * @var string
     */
    protected $paperOrientation;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $destination;

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @return Mpdf
     */
    public function getEngine()
    {
        return $this->mpdf;
    }

    /**
     * @param ResolverInterface $resolver
     * @return MpdfRenderer
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        return $this;
    }

    /**
     * Renders values as a PDF
     *
     * @param string|ModelInterface $nameOrModel The script/resource process, or a view model
     * @param null|array|ArrayAccess $values Values to use during rendering
     * @return string The script output.
     * @throws MpdfException
     */
    public function render($nameOrModel, $values = null)
    {
        $html = $this->getHtmlRenderer()->render($nameOrModel, $values);

        $options = $nameOrModel->getOptions();
        foreach ($options as $setting => $value) {
            $method = 'set' . $setting;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
            unset($method, $setting, $value);
        }
        unset($options);

        if ($this->isDebug()) {
            return $html;
        }

        $orientation = $this->getPaperOrientation();
        $format = substr($orientation, 0, 1);
        if ($format === 'l') {
            $paperSize = $this->getPaperSize() . '-' . $format;
        } else {
            $paperSize = $this->getPaperSize();
        }

        $this->mpdf->_setPageSize($paperSize, $orientation);

        // escreve o conteudo no PDF
        $this->mpdf->WriteHTML($html);

        $fileName = $this->getFilename();
        if (isset($fileName)) {
            if (substr($fileName, -4) != '.pdf') {
                $fileName .= '.pdf';
            }
        }
        return $this->mpdf->Output($fileName, $this->getDestination());
    }

    /**
     * @return Mpdf
     */
    public function getMpdf()
    {
        return $this->mpdf;
    }

    /**
     * @param Mpdf $mpdf
     * @return MpdfRenderer
     */
    public function setMpdf($mpdf)
    {
        $this->mpdf = $mpdf;
        return $this;
    }

    /**
     * @param RendererInterface $renderer
     * @return MpdfRenderer
     */
    public function setHtmlRenderer(RendererInterface $renderer)
    {
        $this->htmlRenderer = $renderer;
        return $this;
    }

    /**
     * @return RendererInterface
     */
    public function getHtmlRenderer()
    {
        return $this->htmlRenderer;
    }

    /**
     * @return string
     */
    public function getPaperSize()
    {
        return $this->paperSize;
    }

    /**
     * @param string $paperSize
     * @return MpdfRenderer
     */
    public function setPaperSize($paperSize)
    {
        $this->paperSize = $paperSize;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaperOrientation()
    {
        return $this->paperOrientation;
    }

    /**
     * @param string $paperOrientation
     * @return MpdfRenderer
     */
    public function setPaperOrientation($paperOrientation)
    {
        $this->paperOrientation = $paperOrientation;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return MpdfRenderer
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     * @return MpdfRenderer
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return MpdfRenderer
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
        return $this;
    }


}
