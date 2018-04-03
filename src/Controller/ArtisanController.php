<?php

namespace App\Controller;

use App\Entity\Artisan;
use App\Form\ArtisanType;
use App\Form\EditArtisanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;



class ArtisanController extends Controller
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function home()
    {
        return new Response('hello artisan');
    }
    /**
     * @Route("/artisan" ,name="artisan")
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @return Response
     */
    public function listArtisan(AuthorizationCheckerInterface $authorizationChecker)
    {

        $em = $this->getDoctrine()->getManager();
        // get the  user who is logged in
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // get the government of the use who is logged in
        $govUser = $user->getVille()->getGovernment();

        // check if the current user has role_admin if yes he get all artisan result
        if (true === $authorizationChecker->isGranted('ROLE_ADMIN'))
        {
            $artisans = $em->getRepository('App:Artisan')->findAll();

        }else {
            // use the method of repository getGovernmentUser
            // return the list of object artisan locate in the same ville of user ville.user = ville.artisan
            $artisans = $em->getRepository('App:Artisan')->getGovernmentUser($govUser);
        }

        // return the response to the view
        return $this->render('artisan/index.html.twig', array(
            'artisans' => $artisans,
            'user' => $user
        ));
    }


    /**
     * @Route("/add-artisan", name="addArtisan")
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

            // message flash for the view
            $this->addFlash('notice', 'the artisan is successfully registered please print his recipe ');
            // redirect to the recipe  route with last id artisan for argument
           return  $this->redirectToRoute('confirmPrintRecipe', array('id' => $artisan->getId()));

        }

        return $this->render('artisan/add.html.twig', [
          'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/add-artisan/{id}",options={"expose"=true} , name="trade")
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
     * @Route("/delete", options={"expose"=true}, name="delete")
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteArtisan(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            // create the instance Json
            $json = new JsonResponse();
            //set the header with content-type json
            $json->headers->set('Content-type', 'application/json');
            // initialise the manager
            $em = $this->getDoctrine()->getManager();
            // get the id of artisan
            $id = $request->query->get('id');
            // load artisan from database
            $artisan = $em->getRepository('App:Artisan')->find($id);
            //test if the artisan doesn't exist return an error status to the error function ajax
            if (null === $artisan) {
                return $json->setData(array(
                    'status' =>'error',
                    'message' =>'ERROR this artisan does not exist  ...'
                ));
            }

            //get the CSRF with the delete-item
            $submittedToken = $request->query->get('token');
            // test if the CSRF is true if of do the delete operation of artisan
            if ($this->isCsrfTokenValid('delete-item', $submittedToken))
            {
                //delete the artisan from database
                $em->remove($artisan);
                $em->flush();
                return $json->setData(array(
                    'status' =>'success',
                    'message' =>'Artisan Deleted Successfully ...'
                ));

            }
        }
    }

    /**
     * @Route("/view-artisan/{id}", options={"expose"=true}, requirements={"id" = "\d+"},  name="artisan_view")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function ViewArtisan(Request $request, $id)
    {
     //  load the artisan from database
        $em = $this->getDoctrine()->getManager();
        $artisan = $em->getRepository('App:Artisan')->find($id);
        // test if the artisan exist else throw an exception
        if (null === $artisan)
        {
            throw new NotFoundHttpException("  The artisan with the id n° ".$id." doesn't exist");
        }
        // create the form from the editformtype
        $form = $this->get('form.factory')->create(EditArtisanType::class, $artisan);
        // handle the request
        $form->handleRequest($request);
        //test if the form is valid and submitted
        if ($form->isSubmitted() && $form->isValid())
        {
            // update the artisan
            $em->persist($artisan);
            $em->flush();
            // edit the flashBag message
            $this->addFlash(
                'notice',
                'Your changes were saved'
            );
            return $this->redirectToRoute('artisans');

        }
        return $this->render('artisan/view.html.twig', array(
            'artisan' => $artisan,
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/print-recipe/{id}", name="printRecipe", requirements={"id"="\d+"})
     * @ParamConverter("Artisan", options={"mapping":{"id": "id"}})
     * @param Artisan $artisan
     * @return Response
     */
    public function printRecipe(Artisan $artisan)
    {
        // get the template
        $template = $this->renderView('artisan/recipe.html.twig', array(
            'artisan' => $artisan
        ));
        // initialise the service htmlToPdf from container
        $html2pdf = $this->get('recipe.html2pdf');
        // create the pdf with the bellow option
        $html2pdf->create('P', 'A4', 'fr', true, 'UTF-8', array(10,15,10,15));
        // return a generated pdf
        return $html2pdf->generatePdf($template, "recipe");

    }

    /**
     * @Route("/confirm-print-recipe/{id}", name="confirmPrintRecipe")
     * @ParamConverter("artisan", options={"mapping" : {"id" : "id"}})
     * @param Artisan $artisan
     * @return Response
     */
    public function confirmPrintRecipe(Artisan $artisan)
    {
        // return a view with artisan instance to confirm print
        return $this->render('artisan/confirm-print-recipe.html.twig', array(
            'artisan' => $artisan
        ));
    }

    /**
     * @Route("/artisans", name="artisans")
     * @Method({"GET"})
     * @return Response
     */
    public function ListArtisanJson()
    {
        // just return a view the response is json data returned by the JsonArtisans action
        return $this->render('artisan/list-artisans.html.twig');
    }

    /**
     * @Route("/all-artisans", options={"expose"=true} , name="all-artisans")
     * @param AuthorizationCheckerInterface $authorizationChecker
     * * @Method({"GET"})
     * @return Response
     */
    public function JsonArtisans(AuthorizationCheckerInterface $authorizationChecker)
    {

        $em = $this->getDoctrine()->getManager();
        // get the  user who is logged in
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // get the government of the use who is logged in
        $govUser = $user->getVille()->getGovernment();

        // check if the current user has role_admin if yes he get all artisan result
        if (true === $authorizationChecker->isGranted('ROLE_ADMIN'))
        {
            $artisans = $em->getRepository('App:Artisan')->findAll();

        }else {
            // use the method of repository getGovernmentUser
            // return the list of object artisan locate in the same ville of user ville.user = ville.artisan
            $artisans = $em->getRepository('App:Artisan')->getGovernmentUser($govUser);
        }
        // get the serializer service from container
        $serializer = $this->container->get('jms_serializer');
        // serialize the data artisan
        $data = $serializer->serialize($artisans, 'json' );
        // create an instance of Response
        $response = new Response($data);
        // set the content type with the application/json to the browser
        $response->headers->set('Content-Type', 'application/json');
        // return response to the list-artisans.html.twig view
         return $response;


    }


}
