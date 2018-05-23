<?php

namespace App\Controller;

use App\Entity\Artisan;
use App\Entity\ArtisanHistory;
use App\Entity\Company;
use App\Entity\CompanyHistory;
use App\Entity\PM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ArtisanSettingController
 * @package App\Controller
 * @Security("is_authenticated()")
 */
class ArtisanSettingController extends Controller
{
    /**
     * @Route("edit/activity/artisan/{id}", name="change-activity")
     * @ParamConverter("Artisan", options={"mapping": {"id":"id"}})
     * @param Request $request
     * @param Artisan $artisan
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, Artisan $artisan)
    {
        $em = $this->getDoctrine()->getManager();
        // get the user agent authenticated
        $id_user=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $em->getRepository('App:User')->find($id_user);

        $history_artisan = new ArtisanHistory();
        $history_artisan->setArtisan($artisan);
        $history_artisan->setActivity($artisan->getActivity());
        $history_artisan->setTrade($artisan->getTrades());
        $history_artisan->setOldCin($artisan->getCin());
        $history_artisan->setOldDateCreation($artisan->getDateCreation());
        $history_artisan->setActivityChanged(true);
        $history_artisan->setGovernment($artisan->getGovernment());
        $history_artisan->setDelegation($artisan->getDelegation());
        $history_artisan->setUser($user);

        $form = $this->createForm('App\Form\EditActivityType', $artisan);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            //dump($artisan);
            $artisan->setIsActivityUpdated(true);
            $em->persist($artisan);
            $em->persist($history_artisan);
            $em->flush();
            // message flash for the view
            $this->addFlash('notice', 'the artisan activity is successfully changed ');
            // redirect to the recipe  route with last id artisan for argument
            return  $this->redirectToRoute('confirmPrintRecipe', array('id' => $artisan->getId()));

        }
        return $this->render('setting/index.html.twig', [
            'artisan' => $artisan,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("edit/government/artisan/{id}", name="change_government")
     * @ParamConverter("Artisan", options={"mapping" : {"id" : "id"}})
     * @param Request $request
     * @param Artisan $artisan
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changeGovernment(Request $request, Artisan $artisan)
    {
        $em =$this->getDoctrine()->getManager();
        // get the user agent authenticated
        $id_user=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $em->getRepository('App:User')->find($id_user);

        $history_artisan = new ArtisanHistory();
        $history_artisan->setArtisan($artisan);
        $history_artisan->setActivity($artisan->getActivity());
        $history_artisan->setTrade($artisan->getTrades());
        $history_artisan->setOldCin($artisan->getCin());
        $history_artisan->setOldDateCreation($artisan->getDateCreation());
        $history_artisan->setActivityChanged(true);
        $history_artisan->setUser($user);
        $history_artisan->setGovernment($artisan->getGovernment());
        $history_artisan->setDelegation($artisan->getDelegation());
        $form = $this->createForm('App\Form\EditGovernmentArtisanType', $artisan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $history_artisan->setGovernmentChanged(true);
            $em->persist($artisan);
            $em->persist($history_artisan);
            $em->flush();
            $this->addFlash('notice', 'Changement d\'adresse de l\'artisan '.$artisan->getLastName().'à été effectué avec succés ');
            // redirect to the recipe  route with last id artisan for argument
            return  $this->redirectToRoute('change_government', array('id' => $artisan->getId()));

        }

        return $this->render('artisan/change_government.html.twig', array(
            'form' => $form->createView(),
            'artisan' => $artisan
        ));
    }

    /**
     * @Route("/edit/gov/{id}",options={"expose"=true} , name="edit_gov")
     * @param $id
     * @Method({"POST"})
     * @return JsonResponse
     */
    public function getDelegation($id)
    {

        $em = $this->getDoctrine()->getManager();
        $governmentDelegation = $em->getRepository('App:Delegation')->findBy(array('government' => $id));

        if($governmentDelegation) {
            foreach ($governmentDelegation as $del)
                $delegation [] = array(
                    'id' => $del->getId(),
                    'name' => $del->getName()
                );

        } else {
            $delegation = null;
        }
        $response = new JsonResponse();
        return $response->setData(
            $delegation
        );
    }

	/**
	 * @Route("edit/activity/government/{id}", name="edit_activity_government")
	 * @param Request $request
	 * @param $id
	 * @param \Swift_Mailer $mailer
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function getDelegationActivity(Request $request, $id, \Swift_Mailer $mailer)
    {

	    $em = $this->getDoctrine()->getManager();
	    $artisan = $em->getRepository(PM::class)->find($id);
        // get the user agent authenticated
        $id_user=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $em->getRepository('App:User')->find($id_user);
         if ($artisan instanceof Artisan)
         {
	         $history_artisan = new ArtisanHistory();
	         $history_artisan->setArtisan($artisan);
	         $history_artisan->setActivity($artisan->getActivity());
	         $history_artisan->setTrade($artisan->getTrades());
	         $history_artisan->setOldCin($artisan->getCin());
	         $history_artisan->setOldDateCreation($artisan->getDateCreation());
	         $history_artisan->setUser($user);
	         $history_artisan->setGovernment($artisan->getGovernment());
	         $history_artisan->setDelegation($artisan->getDelegation());
	         $form = $this->createForm('App\Form\EditGovActivType', $artisan);
	         $form->handleRequest($request);
	         if ($form->isSubmitted() && $form->isValid())
	         {
		         if ($artisan->getActivity() !== $history_artisan->getActivity())
		         {
			         $history_artisan->setActivityChanged(true);

		         }
		         if ($artisan->getGovernment() !== $history_artisan->getGovernment())
		         {
			         $history_artisan->setGovernmentChanged(true);
			         $message = (new \Swift_Message('artisan change de gouvernorat '))
				         ->setFrom(['axavirginienicolas@gmail.com' => 'direction  GPM'])
				         ->setTo([
					         'mahdi-ouerghi@etudiant-is.utm.tn' => 'utm isi',
					         'ouerghi-mahdi@outlook.fr' => 'outlook account'
				         ])
				         ->setBody(
					         'Bonjour agent, l\'artisan  '.$artisan->getFirstName().' '.$artisan->getLastName().' a changé de gouvernorat 
					          de '.$history_artisan->getGovernment()->getName().' au gouvernorat '.$artisan->getGovernment()->getName().
					         'ce mail est transféré directement vers la nouvelle direction de gouvernorat '.$artisan->getGovernment()->getName(),
					         'text/html'
				         );
			         $mailer->send($message);
		         }
		         $em->persist($artisan);
		         $em->persist($history_artisan);
		         $em->flush();

		         $this->addFlash('notice','Opération de modification sur l\'artisan'. $artisan->getId().'a été bien sauvegardé ');
		         return $this->redirectToRoute('confirmPrintRecipe', array('id' => $artisan->getId()));
	         }
	         return $this->render('edit_gov_activity.html.twig', array(
		         'artisan' => $artisan,
		         'form' => $form->createView()
	         ));
         }
         if ($artisan instanceof Company)
         {
	         $history_company = new CompanyHistory();
	         $history_company->setCompany($artisan);
	         $history_company->setName($artisan->getName());
	         $history_company->setActivity($artisan->getActivity());
	         $history_company->setTrade($artisan->getTrades());
	         $history_company->setOldDateCreation($artisan->getDateCreation());
	         $history_company->setUser($user);
	         $history_company->setGovernment($artisan->getGovernment());
	         $history_company->setDelegation($artisan->getDelegation());
	         $form = $this->createForm('App\Form\SettingCompanyType', $artisan);
	         $form->handleRequest($request);
	         if ($form->isSubmitted() && $form->isValid())
	         {
		         if ($artisan->getActivity() !== $history_company->getActivity())
		         {
			         $history_company->setActivityChanged(true);

		         }
		         if ($artisan->getGovernment() !== $history_company->getGovernment())
		         {
			         $history_company->setGovernmentChanged(true);
			         if ($artisan->getGovernment() !== $history_company->getGovernment())
			         {
				         $history_company->setGovernmentChanged(true);
				         $message = (new \Swift_Message('company change de gouvernorat '))
					         ->setFrom(['axavirginienicolas@gmail.com' => 'ouerghi mahdouch'])
					         ->setTo([
					         	'mahdi-ouerghi@etudiant-is.utm.tn' => 'utm isi',
					            'ouerghi-mahdi@outlook.fr' => 'outlook account'
					         ])
					         ->setBody(
						         'Bonjour la société  '.$artisan->getName().' a changé de gouvernorat 
					          de '.$history_company->getGovernment()->getName().' au gouvernorat '.$artisan->getGovernment()->getName().
						         'ce mail est transféré directement vers la nouvelle direction de gouvernorat '.$artisan->getGovernment()->getName(),
						         'text/html'
					         );
				         $mailer->send($message);
			         }
		         }
		         $em->persist($artisan);
		         $em->persist($history_company);
		         $em->flush();
		         $this->addFlash('notice','Opération de modification sur la société '. $artisan->getName().'a été bien sauvegardé ');
		         return $this->redirectToRoute('confirmPrintRecipe', array('id' => $artisan->getId()));
	         }
	         return $this->render('edit_gov_activity.html.twig', array(
		         'artisan' => $artisan,
		         'form' => $form->createView()
	         ));
         }

    }

}
