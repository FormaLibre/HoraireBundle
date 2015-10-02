<?php

namespace FormaLibre\HoraireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation as SEC;
use Claroline\CoreBundle\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use FormaLibre\HoraireBundle\Entity\Period;
use FormaLibre\HoraireBundle\Entity\TimeSlot;


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
    private $timeSlotRepo;
    
      
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
        $this->timeSlotRepo       = $om->getRepository('FormaLibreHoraireBundle:TimeSlot');
  
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
    
            /**
     * @EXT\Route(
     *     "/admin/horaire/horaires/type",
     *     name="formalibre_horaire_horaires_type",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @param User $user
     * @EXT\Template()
     */
    public function adminHoraireTypeAction()
            
    {   $AllVisiblePeriod=$this->periodRepo->findByVisibility(true); 
        
        $LastVisiblePeriod=$this->periodRepo->findOneBy(array('visibility'=>true), array('id' => 'desc'),1,0);
         
        if(!is_null($LastVisiblePeriod)){
            $TimeSlot = $this->timeSlotRepo->findByPeriodId($LastVisiblePeriod); 
            $SelectedPeriod=$LastVisiblePeriod;
           
            $PeriodSelection = $this ->createFormBuilder()
            
                ->add ('selection','entity',array (
                    'class' => 'FormaLibreHoraireBundle:Period',
                    'property' => 'periodName',
                    'query_builder'=> function(EntityRepository $repository) {
                        return $repository->createQueryBuilder ('u')
                                ->where ('u.visibility = :actif')
                                ->setParameter('actif',true);
                    },
                    'empty_value' =>' Changer de période',))
                ->add ('valider','submit',array (
                    'label'=>'Comfirmer ?'))
                ->getForm();

            $PeriodName=$LastVisiblePeriod->getPeriodName();

            $request = $this->getRequest();
                if ($request->getMethod() == 'POST')
                {
                    $PeriodSelection->handleRequest($request);
                    $SelectedPeriod = $PeriodSelection->get("selection")->getData();
                    $TimeSlot = $this->timeSlotRepo->findByPeriodId($SelectedPeriod);
                    $PeriodName=$SelectedPeriod->getPeriodName();
                }  
        }
        
        else{
              $PeriodName="Aucune période existante/visible";
              $TimeSlot = $this->timeSlotRepo->findAll() ;
              $SelectedPeriod=array();
              $PeriodSelection = $this ->createFormBuilder()
           
                ->add ('selection','entity',array (
                    'class' => 'FormaLibreHoraireBundle:Period',
                    'property' => 'speriodName',
                    'query_builder'=> function(EntityRepository $repository) {
                        return $repository->createQueryBuilder ('u')
                                ->where ('u.visibility = :actif')
                                ->setParameter('actif',true);
                    },
                    'empty_value' =>' Changer de période',))
                ->add ('valider','submit',array (
                    'label'=>'Comfirmer ?'))
                ->getForm();
        }
                 
       return array('timeSlot'=> $TimeSlot,                       
                    'periodName'=>$PeriodName,
                    'selectedPeriod'=>$SelectedPeriod,
                    'periodSelection'=>$PeriodSelection->createView());
    }
    
 
            /**
     * @EXT\Route(
     *     "/admin/horaire/new/timeSlot/momentTime/{momentTime}/momentDate/{momentDate}/period/{period}",
     *     name="formalibre_horaire_new_timeSlot",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @param User $user
     * @EXT\Template()
     */
    public function adminNewTimeSlotAction($momentTime, $momentDate, $period)
            
    { 
        $selectedPeriod=$this->periodRepo->findOneById($period);
        $NewTimeSlotForm = $this ->createFormBuilder()

        ->add('day', 'choice', array(
                'choices'   => array(
                'monday'   => 'lundi',
                'tuesday' => 'mardi',
                'wednesday'   => 'mercredi',
                'thursday'   => 'jeudi',
                'friday'   => 'vendredi',
                'saturday'   => 'samedi',
                ),
            'multiple'  => true,
            'expanded'  => true,
            ))
        ->add('name','text',array(
                'required'=>false ))        
        ->add('start','text')
        ->add('end','text')
        ->add ('valider','submit',array (
            'label'=>'Ajouter'))

        ->getForm();

            
            return array('newTimeSlotForm'=>$NewTimeSlotForm ->createView(),
                         'momentTime'=>$momentTime,
                         'momentDate'=>$momentDate,
                         'selectedPeriod'=>$selectedPeriod);
        }  
        
                /**
     * @EXT\Route(
     *     "/admin/horaire/add/timeSlot/period/{period}",
     *     name="formalibre_horaire_add_timeslot",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @param User $user
     */
    public function adminAddTimeSlotAction($period)
            
    {  
        $actualPeriod=$this->periodRepo->findOneById($period);
        $NewTimeSlotForm = $this ->createFormBuilder()

        ->add('day', 'choice', array(
                'choices'   => array(
                'monday'   => 'lundi',
                'tuesday' => 'mardi',
                'wednesday'   => 'mercredi',
                'thursday'   => 'jeudi',
                'friday'   => 'vendredi',
                'saturday'   => 'samedi',
                ),
            'multiple'  => true,
            'expanded'  => true,
            ))
        ->add('name','text',array(
                'required'=>false ))        
        ->add('start','text')
        ->add('end','text')
        ->add ('valider','submit',array (
            'label'=>'Ajouter'))

        ->getForm();
        
            $request = $this->getRequest();
            if ($request->getMethod() === 'POST') {
                
                $NewTimeSlotForm->handleRequest($request);
                $startHour = $NewTimeSlotForm->get("start")->getData();
                $endHour = $NewTimeSlotForm->get("end")->getData();
                $name = $NewTimeSlotForm->get("name")->getData();
                $wichDay =$NewTimeSlotForm->get("day")->getData();
                
                $startHourFormat = \DateTime::createFromFormat('H:i', $startHour);
                $endHourFormat = \DateTime::createFromFormat('H:i', $endHour);
    
                    $BeginPeriodDate=$actualPeriod->getPeriodBegin();
                    $EndPeriodDate=$actualPeriod->getPeriodEnd();
                  
                    foreach ($wichDay as $oneDay) {
                       
                        $begin = $BeginPeriodDate;
                        $begin->modify('last '.$oneDay);  
                        $interval = new \DateInterval('P1W'); //interval d'une semaine
                        $end = $EndPeriodDate;
                        $end->modify('next '.$oneDay); //dernier jour du mois
                        $duree = new \DatePeriod($begin, $interval, $end);
                                         
                        foreach ($duree as $date) {
                            $dateFormat = $date->format("Y-m-d");
                            $dayNameFormat=$date->format("l");

                            $actualTimeSlot = new TimeSlot();
                            $actualTimeSlot->setBeginHour($startHourFormat);
                            $actualTimeSlot->setEndHour($endHourFormat);
                            $actualTimeSlot->setDate($date);
                            $actualTimeSlot->setDay($dayNameFormat);
                            $actualTimeSlot->setName($name);
                            $actualTimeSlot->setPeriodId($actualPeriod);
 
                            $this->em->persist($actualTimeSlot);
                            $this->em->flush();  
                        }
                    }
            
  
               return new JsonResponse('success',200); 
            }
        
        return array();
    }
        
    /**
     * @EXT\Route(
     *     "/admin/horaire/change/timeSlot/timeslot/{timeslot}",
     *     name="formalibre_horaire_change_timeslot",
     *     options={"expose"=true}
     * )
     *
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     * @param User $user
     * @EXT\Template()
     */
    public function adminChangeTimeSlotAction($timeslot)
            
    { 
        $actualTimeSlot=$this->timeSlotRepo->findOneById($timeslot);
        $dayActual=$actualTimeSlot->getDay();
        $periodActual=$actualTimeSlot->getPeriodId();
        $ModifTimeSlotForm = $this ->createFormBuilder()
         
            ->add('changeName','text')
            ->add('changeStart','text')
            ->add('changeEnd','text')
            ->add ('modifier','submit')
            ->getForm();

                $request = $this->get('request');
                
                if($request->getMethod()=='POST'){
                $ModifTimeSlotForm->handleRequest($request);
               
                $startHour = $ModifTimeSlotForm->get("changeStart")->getData();
                $endHour = $ModifTimeSlotForm->get("changeEnd")->getData();
                $name = $ModifTimeSlotForm->get("changeName")->getData();

                $startHourFormat = \DateTime::createFromFormat('H:i', $startHour);
                $endHourFormat = \DateTime::createFromFormat('H:i', $endHour);
                               
                $timeSlotToModif = $this->timeSlotRepo->findBy(array('beginHour'=>$startHourFormat,
                                                                         'endHour'=>$endHourFormat, 
                                                                         'day'=>$dayActual,
                                                                         'periodId'=>$periodActual));
                

                    foreach ($timeSlotToModif as $OneTimeSlotToModif) {

                        $OneTimeSlotToModif->setName($name);
                        $OneTimeSlotToModif->setBeginHour($startHourFormat);
                        $OneTimeSlotToModif->setEndHour($endHourFormat);

                    }    
                    $this->em->flush();

             return new JsonResponse('success',200);
                    
            }    
          
       return array('ModifTimeSlotForm' => $ModifTimeSlotForm->createView(),
                    'actualtimeslot'=>$actualTimeSlot);
    } 
     
}


    


