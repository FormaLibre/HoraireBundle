<?php

namespace FormaLibre\HoraireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation as SEC;



/**
 * @DI\Tag("security.secure_service")
 * @SEC\PreAuthorize("canOpenAdminTool('formalibre_horaire_tool')")
 */
class HoraireController extends Controller
{
   
       /**
     * @EXT\Route(
     *     "/horaire/tool/index",
     *     name="formalibre_horaire_tool_index",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @EXT\Template()
     */
    public function ToolIndexAction()
    {
        
              
    }
        
     
}