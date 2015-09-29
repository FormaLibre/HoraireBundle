<?php

namespace FormaLibre\HoraireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation as SEC;
use Claroline\CoreBundle\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use FormaLibre\HoraireBundle\Entity\Period;



/**
 * @DI\Tag("security.secure_service")
 * @SEC\PreAuthorize("canOpenAdminTool('formalibre_horaire_admin_tool')")
 */
class AdminHoraireController extends Controller
{
    
    private $om;
    private $em;
    private $router;
    
    private $periodRepo;
    
      
    /**
     * @DI\InjectParams({
     *      "om"                 = @DI\Inject("claroline.persistence.object_manager"),
     *      "em"                 = @DI\Inject("doctrine.orm.entity_manager"),
     *      "router"             = @DI\Inject("router"),
     * })
     */
    public function __construct(
        ObjectManager $om,
        EntityManager $em,
        RouterInterface $router

    )
    {   $this->router             =$router;          
        $this->om                 = $om;
        $this->em                 = $em; 
        $this->userRepo           = $om->getRepository('ClarolineCoreBundle:User');  
        $this->periodRepo         = $om->getRepository('FormaLibreHoraireBundle:Period');
  
    }
   
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
        
     $AllPeriod=$this->periodRepo->findAll();   
     $NewPeriodForm = $this ->createFormBuilder()
        
            ->add('name','text')
            ->add('beginDate','text')
            ->add('endDate','text')
            ->add('beginHour','text')
            ->add('endHour','text')
            ->add('visible','checkbox',array(
                  'required'  => false,)
            )
            ->add ('valider','submit',array (
                'label'=>'Ajouter'))
               
            ->getForm();
 
        return array('NewPeriodForm' => $NewPeriodForm->createView(),
                     'allPeriod'=>$AllPeriod); 
    }
    
      /**
     * @EXT\Route(
     *     "/admin/presence/add/period",
     *     name="formalibre_horaire_admin_add_period",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @EXT\Template()
     */
    public function adminAddPeriodAction(){
        
         $NewPeriodForm = $this ->createFormBuilder()
        
            ->add('name','text')
            ->add('beginDate','text')
            ->add('endDate','text')
            ->add('beginHour','text')
            ->add('endHour','text')
            ->add('visible','checkbox',array(
                  'required'  => false,)
            )
            ->add ('valider','submit',array (
                'label'=>'Ajouter'))
               
            ->getForm();
        
         $request = $this->getRequest();
            
            if ($request->getMethod() === 'POST') {
                
                
                $NewPeriodForm->handleRequest($request);
                
                $name = $NewPeriodForm->get("name")->getData();
                $beginDate = $NewPeriodForm->get("beginDate")->getData();
                $endDate= $NewPeriodForm->get("endDate")->getData();
                $beginHour=$NewPeriodForm->get("beginHour")->getData();
                $endHour = $NewPeriodForm->get("endHour")->getData();
                $visible= $NewPeriodForm->get("visible")->getData();
                
                $beginDateFormat = \DateTime::createFromFormat('d-m-Y', $beginDate);
                $endDateFormat = \DateTime::createFromFormat('d-m-Y', $endDate);
                $beginHourFormat = \DateTime::createFromFormat('H:i', $beginHour);
                $endHourFormat = \DateTime::createFromFormat('H:i', $endHour);
                
                $actualPeriod = new Period();
                $actualPeriod->setPeriodName($name);
                $actualPeriod->setPeriodBegin($beginDateFormat);
                $actualPeriod->setPeriodEnd($endDateFormat);
                $actualPeriod->setPeriodBeginHour($beginHourFormat);
                $actualPeriod->setPeriodEndHour($endHourFormat);
                $actualPeriod->setVisibility($visible);
                $this->em->persist($actualPeriod);
                $this->em->flush();
      
            } 
                return $this->redirect($this->generateUrl('formalibre_horaire_admin_tool_index'));    
    }
    
               /**
     * @EXT\Route(
     *     "/presence/period/modif/id/{thePeriod}",
     *     name="formalibre_period_modif",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @param User $user
     * @EXT\Template()
     */
    public function PeriodModifAction(Period $thePeriod)
            
    {      
        $ModifPeriodForm = $this ->createFormBuilder()
        
            ->add('nameModifPeriod','text')
            ->add('beginDateModifPeriod','text')
            ->add('endDateModifPeriod','text')
            ->add('beginHourModifPeriod','text')
            ->add('endHourModifPeriod','text')
            ->add('visibleModifPeriod','checkbox',array(
                  'required'  => false,)
            )
            ->add ('validerModifPeriod','submit',array (
                'label'=>'Ajouter'))
               
            ->getForm();
        
         $request = $this->getRequest();
            
            if ($request->getMethod() === 'POST') {
                 
                
                $ModifPeriodForm->handleRequest($request);
                
                $modifName = $ModifPeriodForm->get("nameModifPeriod")->getData();
                $modifBeginDate = $ModifPeriodForm->get("beginDateModifPeriod")->getData();
                $modifEndDate= $ModifPeriodForm->get("endDateModifPeriod")->getData();
                $modifBeginHour=$ModifPeriodForm->get("beginHourModifPeriod")->getData();
                $modifEndHour = $ModifPeriodForm->get("endHourModifPeriod")->getData();
                $modifVisible= $ModifPeriodForm->get("visibleModifPeriod")->getData();
                
                $beginDateFormat = \DateTime::createFromFormat('d-m-Y', $modifBeginDate);
                $endDateFormat = \DateTime::createFromFormat('d-m-Y', $modifEndDate);
                $beginHourFormat = \DateTime::createFromFormat('H:i', $modifBeginHour);
                $endHourFormat = \DateTime::createFromFormat('H:i', $modifEndHour);
                
                $thePeriod->setPeriodName($modifName);
                $thePeriod->setPeriodBegin($beginDateFormat);
                $thePeriod->setPeriodEnd($endDateFormat);
                $thePeriod->setPeriodBeginHour($beginHourFormat);
                $thePeriod->setPeriodEndHour($endHourFormat);
                $thePeriod->setVisibility($modifVisible);
                $this->em->persist($thePeriod);
                $this->em->flush();
      
                return new JsonResponse("success",200);
                }
        
       return array('ModifPeriodForm' => $ModifPeriodForm->createView(),
                    'thePeriod'=>$thePeriod);
    }
    
    /**
     * @EXT\Route(
     *     "/presence/period/supprimer/thePeriod/{thePeriod}",
     *     name="formalibre_period_supprimer",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @param User $user
     */
    public function PeriodSupprimerAction(Period $thePeriod)
            
    {      
        $this->em->remove($thePeriod);
        $this->em->flush();
 
       return new JsonResponse("success",200);
    }
    
        
     
}


    


