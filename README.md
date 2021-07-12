# Zetta\\ZendMPDF

Módulo para geração de PDF no ZendFramework 3 utilizando o mpdf.

A instalação do MPDFModule utiliza o PHP Composer. Para mais informações sobre PHP Composer, por favor visite o site oficial [PHP Composer](http://getcomposer.org/).

## Requerimentos
  - [Zend Framework 3](http://github.com/zendframework/zendframework)
  - [MPDF ^7.1](http://github.com/mpdf/mpdf)

### Installation

You can install this plugin into your Zend Framework application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require zetta-code/zend-mpdf
```

## Exemplo de utilização

```php
<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Zetta\ZendMPDF\View\Model\MpdfModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $mpdf = new MpdfModel();
        $mpdf->setOption('paperSize', 'A3') // padrão "A4"
            ->setOption('paperOrientation', 'landscape'); // Padrão "portrait"
        return $mpdf;
    }
}
```
