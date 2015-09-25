<?php

namespace FormaLibre\HoraireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation as SEC;



/**
 * @DI\Tag("security.secure_service")
 * @SEC\PreAuthorize("canOpenAdminTool('formalibre_horaire_admin_tool')")
 */
class AdminHoraireController extends Controller
{
   
       /**
     * @EXT\Route(
     *     "/admin/horaire/tool/index",
     *     name="formalibre_horaire_admin_tool_index",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @EXT\Template()
     */
    public function adminToolIndexAction()
    {
        
   
     $NewPeriodForm = $this ->createFormBuilder()
        
            ->add('name','text')
            ->add('beginDate','text')
            ->add('endDate','text')
            ->add('beginHour','text')
            ->add('endHour','text')
            ->add('visible','checkbox',array(
                  'required'  => false,)
            )
            ->add ('valider2','submit',array (
                'label'=>'Ajouter'))
               
            ->getForm();
 
        return array('NewPeriodForm' => $NewPeriodForm->createView()); 
    }
        
     
}


    


