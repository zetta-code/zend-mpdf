<?php
/**
 * @link      http://github.com/zetta-repo/zend-mpdf for the canonical source repository
 * @copyright Copyright (c) 2016 Zetta Code
 */

declare(strict_types=1);

namespace Zetta\ZendMPDF\View\Strategy;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\View\ViewEvent;
use Zetta\ZendMPDF\View\Model\MpdfModel;
use Zetta\ZendMPDF\View\Renderer\MpdfRenderer;

class MpdfStrategy extends AbstractListenerAggregate
{
    /**
     * @var MpdfRenderer
     */
    protected $renderer;

    /**
     * MpdfStrategy constructor.
     * @param MpdfRenderer $renderer
     */
    public function __construct(MpdfRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Attach the aggregate to the specified event manager
     *
     * @param EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, [$this, 'selectRenderer'], $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, [$this, 'injectResponse'], $priority);
    }

    /**
     * Detect if we should use the MpdfRenderer based on model type
     *
     * @param ViewEvent $e
     * @return null|MpdfRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();

        if (! $model instanceof MpdfModel) {
            // no JsonModel; do nothing
            return;
        }

        // MpdfModel found
        return $this->renderer;
    }

    /**
     * Inject the response with the PDF payload and appropriate Content-Type header
     *
     * @param ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            // Discovered renderer is not ours; do nothing
            return;
        }

        $result = $e->getResult();

        if (! is_string($result)) {
            // @todo Potentially throw an exception here since we should *always* get back a result.
            return;
        }
        $response = $e->getResponse();
        $response->setContent($result);

        if ($e->getModel()->getOptions()['debug']) {
            $response->getHeaders()->addHeaderLine('content-type', 'text/html');
        } else {
            $response->getHeaders()->addHeaderLine('content-type', 'application/pdf');
        }
    }
}
