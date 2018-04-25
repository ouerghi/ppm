<?php

namespace App\Controller;

use App\Entity\Artisan;
use App\Entity\ArtisanHistory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArtisanSettingController extends Controller
{
    /**
     * @Route("edit/activity/artisan/{id}", name="change-activity")
     * @ParamConverter("Artisan", options={"mapping": {"id":"id"}})
     * @param Request $request
     * @param Artisan $artisan
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
     * @ParamConverter("Artisan", options={"mapping": {"id":"id"}})
     * @param Request $request
     * @param Artisan $artisan
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDelegationActivity(Request $request, Artisan $artisan, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('artisan change de gouvernorat '))
            ->setFrom('ouerghimahdi1@gmail.com.com')
            ->setTo('artisan@gmail.com')
            ->setBody(
                'hello  artisan ',
                'text/html'
            );
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

          }

            $em->persist($artisan);
            $em->persist($history_artisan);
            $em->flush();
            $mailer->send($message);
            $this->addFlash('notice','Opération de modification sur l\'artisan'. $artisan->getId().'a été bien sauvegardé ');
            return $this->redirectToRoute('edit_activity_government', array('id' => $artisan->getId()));
        }
        return $this->render('edit_gov_activity.html.twig', array(
            'artisan' => $artisan,
            'form' => $form->createView()
        ));
    }

}
