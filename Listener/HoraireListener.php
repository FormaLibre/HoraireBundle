<?php

namespace FormaLibre\HoraireBundle\Listener;

use Claroline\CoreBundle\Event\DisplayWidgetEvent;
use Claroline\CoreBundle\Event\OpenAdministrationToolEvent;
use Claroline\CoreBundle\Event\DisplayToolEvent;
use Claroline\CoreBundle\Listener\NoHttpRequestException;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @DI\Service
 */
class HoraireListener

{
    private $httpKernel;
    private $request;
    /**
     * @DI\InjectParams({
     *     "httpKernel"   = @DI\Inject("http_kernel"),
     *     "requestStack" = @DI\Inject("request_stack")
     * })
     */
    public function __construct(HttpKernelInterface $httpKernel,RequestStack $requestStack)
    {
        
        $this->httpKernel = $httpKernel;
        $this->request = $requestStack->getCurrentRequest();
        
    }
    /**
     * @DI\Observe("administration_tool_formalibre_horaire_admin_tool")
     *
     * @param DisplayToolEvent $event
     */
    public function onAdministrationToolOpen(OpenAdministrationToolEvent $event)
    
    {
        
        $params = array();
        $params['_controller'] = 'FormaLibreHoraireBundle:AdminHoraire:adminToolIndex';
        $subRequest = $this->request->duplicate(array(), null, $params);
        $response = $this->httpKernel
            ->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        $event->setResponse($response);
        $event->stopPropagation();
    }
    
    /**
     * @DI\Observe("open_tool_desktop_formalibre_horaire_tool")
     *
     * @param DisplayToolEvent $event
     */
    public function onToolOpen(DisplayToolEvent $event)
    
    {
        
        $params = array();
        $params['_controller'] = 'FormaLibreHoraireeBundle:Horaire:ToolIndex';
        $subRequest = $this->request->duplicate(array(), null, $params);
        $response = $this->httpKernel
            ->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        $event->setContent($response->getContent());
        $event->stopPropagation();
    }
    
    
    
}