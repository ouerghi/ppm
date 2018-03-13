<?php

namespace App\Controller;

use App\Entity\Artisan;
use App\Form\ArtisanType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ArtisanController extends Controller
{

    /**
     * @Route("/artisan", name="artisan")
     */
    public function listArtisan()
    {
        return $this->render('artisan/index.html.twig');
    }
    /**
     * @Route("/add-artisan", name="addArtisan")
     */
    public function addArtisan(Request $request)
    {

        $artisan = new Artisan();
        $form = $this->createForm('App\Form\ArtisanType', $artisan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $id_user=$this->get('security.token_storage')->getToken()->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('App:User')->find($id_user);
            // set the user for the artisan
            $artisan->setUser($user);
            // persist and flush the artisan entity
            $em->persist($artisan);
            $em->flush();

            // clear form after successful submit
            unset($artisan);
            unset($form);
            $artisan = new Artisan();
            $form = $this->createForm('App\Form\ArtisanType', $artisan);
            // message flash for the view
            $this->addFlash('notice', 'the artisan is successfully registered');
            // redirect to the artisan route
            $this->redirectToRoute('artisan');

        }

        return $this->render('artisan/add.html.twig', [
          'form' => $form->createView()
        ]);
    }
}
