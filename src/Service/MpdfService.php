<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

declare(strict_types=1);

namespace Zetta\ZendMPDF\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Stdlib\ArrayUtils;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class MpdfService implements FactoryInterface
{
    /**
     * @var string
     */
    protected $dir = './data/mpdf';

    /**
     * @var string
     */
    protected $temp = '/tmp';

    /**
     * @var string
     */
    protected $ttfonts = '/ttfonts';

    /**
     * @var array
     */
    protected $fontdata = [];

    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        $config = isset($config['zend_mpdf']) ? $config['zend_mpdf'] : [];

        if (isset($config['dir'])) {
            $this->dir = $config['dir'];
        }
        if (isset($config['tmp'])) {
            $this->temp = $config['tmp'];
        }
        $this->temp = $this->dir . $this->temp;
        if (isset($config['ttfonts'])) {
            $this->ttfonts = $config['ttfonts'];
        }
        $this->ttfonts = $this->dir . $this->ttfonts;
        if (isset($config['fontdata'])) {
            $this->fontdata = $config['fontdata'];
        }

        $this->makeDirs();

        $config = $this->mpdfConfig();

        return new Mpdf($config);
    }

    public function makeDirs(): void
    {
        if (! file_exists($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
        if (! file_exists($this->temp)) {
            mkdir($this->temp, 0777, true);
        }
        if (! file_exists($this->ttfonts)) {
            mkdir($this->ttfonts, 0777, true);
        }
    }

    /**
     * @return array
     */
    public function mpdfConfig(): array
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDir = $defaultConfig['fontDir'];
        $fontDir[] = $this->ttfonts;

        $fontConfig = (new FontVariables())->getDefaults();
        $fontdata = $fontConfig['fontdata'];
        if (count($this->fontdata) > 0) {
            $fontdata = ArrayUtils::merge($fontConfig['fontdata'], $this->fontdata);
        }

        return [
            'fontDir' => $fontDir,
            'tempDir' => $this->temp,
            'fontdata' => $fontdata,
        ];
    }
}
