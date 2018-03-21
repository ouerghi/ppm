<?php

namespace App\Controller;

use App\Entity\Artisan;
use App\Form\ArtisanType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ArtisanController extends Controller
{
    /**
     * @Route("/artisan", name="artisan")
     */
    public function listArtisan()
    {
        $em = $this->getDoctrine()->getManager();
        $artisans = $em->getRepository('App:Artisan')->findAll();
        return $this->render('artisan/index.html.twig', array(
            'artisans' => $artisans
        ));
    }


    /**
     * @Route("/add-artisan/", name="addArtisan")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addArtisan(Request $request)
    {

        $artisan = new Artisan();
        $id_user=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('App:User')->find($id_user);
        // government  of user(admin,drc ...)
        $governemnt = $user->getVille()->getGovernment();

        // create the form builder with the ville of user who is the app
        $form = $this->createForm(ArtisanType::class, $artisan,array(
            'government' => $governemnt
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            // set the user for the artisan
            $artisan->setUser($user);
            // persist and flush the artisan entity
            $em->persist($artisan);
            $em->flush();

            // clear form after successful submit
            unset($artisan);
            unset($form);
            $artisan = new Artisan();
            $form = $this->createForm(ArtisanType::class, $artisan);
            // message flash for the view
            $this->addFlash('notice', 'the artisan is successfully registered');
            // redirect to the artisan route
            $this->redirectToRoute('artisan');

        }

        return $this->render('artisan/add.html.twig', [
          'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/add-artisan/{id}", name="trade")
     * @param $id
     * @return JsonResponse
     */
    public function getTrades($id)
    {

      $em = $this->getDoctrine()->getManager();
      $activityTrade = $em->getRepository('App:Trades')->findBy(array('activities' => $id));

      if($activityTrade) {
          foreach ($activityTrade as $tri)
          $trade [] = array(
              'id' => $tri->getId(),
              'name' => $tri->getName()
          );

      } else {
          $trade = null;
      }
      $response = new JsonResponse();
      return $response->setData(
           $trade
      );
    }

    /**
     * @Route("/delete-artisan/{id}", name="artisan_delete")
     * @param $id
     * @return Response
     */
    public function deleteArtisan($id)
    {
        return new Response('delete page');
    }

    /**
     * @Route("/view-artisan/{id}", name="artisan_view")
     * @param $id
     * @return Response
     */
    public function ViewArtisan($id)
    {
        return new Response('view artisan page');
    }
}
