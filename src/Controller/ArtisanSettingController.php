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
        $government = new Artisan();
        $form = $this->createForm('App\Form\EditGovernmentArtisanType', $government);
        return $this->render('artisan/change_government.html.twig', array(
            'form' => $form->createView()
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

}
