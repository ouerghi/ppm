<?php

namespace App\Controller;

use App\Entity\Artisan;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArtisanSettingController extends Controller
{
    /**
     * @Route("/activity/artisan/{id}", name="change-activity")
     * @ParamConverter("Artisan", options={"mapping": {"id":"id"}})
     * @param Request $request
     * @param Artisan $artisan
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, Artisan $artisan)
    {
        $em = $this->getDoctrine()->getManager();

        $id_user=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $em->getRepository('App:User')->find($id_user);

        $artisan_new_activity = new Artisan();
        $form = $this->createForm('App\Form\EditActivityType', $artisan_new_activity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $cin = $form->get('cin')->getData();

            if ( $artisan->getCin() === $cin)
            {
                return  $this->redirectToRoute('change-activity', array('id' => $artisan_new_activity->getId()));
            }
            $artisan_new_activity = clone $artisan;
            $artisan_new_activity->setCin($cin);
            $artisan_new_activity->setIsActivityUpdated(true);
            $artisan_new_activity->setUser($user);
            $artisan_new_activity->setOldIdArtisan($artisan->getId());

            $em->persist($artisan_new_activity);
            $em->flush();
            // message flash for the view
            $this->addFlash('notice', 'the artisan activity is successfully changed ');
            // redirect to the recipe  route with last id artisan for argument
            return  $this->redirectToRoute('confirmPrintRecipe', array('id' => $artisan_new_activity->getId()));

        }
        return $this->render('setting/index.html.twig', [
            'artisan' => $artisan,
            'form' => $form->createView()
        ]);
    }
}
