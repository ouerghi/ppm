<?php

namespace App\Controller;

use App\Entity\Artisan;
use App\Entity\ArtisanHistory;
use App\Entity\Company;
use App\Entity\CompanyHistory;
use App\Entity\PM;
use App\Form\ArtisanType;
use App\Form\CompanyType;
use App\Form\EditArtisanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


/**
 * @Security("is_granted('ROLE_DRC')")
 */
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
        $govUser = $user->getGovernment()->getId();

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
	    $company = new Company();
        $id_user=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('App:User')->find($id_user);
        // government  of user(admin,drc ...)
        $government = $user->getGovernment()->getId();

        // create the form builder with the ville of user who is the app
        $form = $this->createForm(ArtisanType::class, $artisan,array(
            'government' => $government
        ));
        $form_company = $this->createForm(CompanyType::class, $company, array(
        	'government' => $government
        ));
        $form->handleRequest($request);
	    $form_company->handleRequest($request);
        if ( ($form->isSubmitted() && $form->isValid()) || ($form_company->isSubmitted() && $form_company->isValid()) )
        {
	        if ($request->request->has('company')) {
		       $government = $company->getDelegation()->getGovernment();
		       $company->setGovernment($government);
		       $company->setUser($user);
		       $em->persist($company);
		       $em->flush();
		       $this->addFlash('notice', 'la société est enregistré avec succès, veuillez imprimer sa fiche. ');
		        return  $this->redirectToRoute('confirmPrintRecipe', array('id' => $company->getId()));
	        }
	        if ($request->request->has('artisan')) {
		        $government = $artisan->getDelegation()->getGovernment();
		        $artisan->setGovernment($government);
		        // set the user for the artisan
		        $artisan->setUser($user);
		        // persist and flush the artisan entity
		        $em->persist($artisan);
		        $em->flush();
		        $this->addFlash('notice', 'l\'artisan est enregistré avec succès, veuillez imprimer sa fiche. ');
		        return  $this->redirectToRoute('confirmPrintRecipe', array('id' => $artisan->getId()));
	        }
            // message flash for the view

            // redirect to the recipe  route with last id artisan for argument
           return  $this->redirectToRoute('confirmPrintRecipe', array('id' => $artisan->getId()));

        }

        return $this->render('artisan/add.html.twig', [
          'form' => $form->createView(),
          'form_company' => $form_company->createView()
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
            $artisan = $em->getRepository(PM::class)->find($id);
            // get the user agent authenticated
            $id_user=$this->get('security.token_storage')->getToken()->getUser()->getId();
            $user = $em->getRepository('App:User')->find($id_user);


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
	            if ($artisan instanceof Artisan)
	            {
		            $history_artisan = new ArtisanHistory();
		            $history_artisan->setArtisan($artisan);
		            $history_artisan->setActivity($artisan->getActivity());
		            $history_artisan->setTrade($artisan->getTrades());
		            $history_artisan->setDelegation($artisan->getDelegation());
		            $history_artisan->setGovernment($artisan->getGovernment());
		            $history_artisan->setOldCin($artisan->getCin());
		            $history_artisan->setOldDateCreation($artisan->getDateCreation());
		            $history_artisan->setIsDeleted(true);
		            $history_artisan->setUser($user);

		            $artisan->setIsDeleted(true);
		            $em->persist($history_artisan);
		            //delete the artisan from database
		            $em->persist($artisan);
	            }
	            if ($artisan instanceof Company)
	            {
		            $history_company = new CompanyHistory();
		            $history_company->setCompany($artisan);
		            $history_company->setName($artisan->getName());
		            $history_company->setActivity($artisan->getActivity());
		            $history_company->setTrade($artisan->getTrades());
		            $history_company->setDelegation($artisan->getDelegation());
		            $history_company->setGovernment($artisan->getGovernment());
		            $history_company->setOldDateCreation($artisan->getDateCreation());
		            $history_company->setIsDeleted(true);
		            $history_company->setUser($user);
		            $artisan->setIsDeleted(true);
		            $em->persist($history_company);
		            //delete the artisan from database
		            $em->persist($artisan);
	            }

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
        $user = $artisan->getUser();
        $government = $user->getGovernment()->getId();

        // test if the artisan exist else throw an exception
        if (null === $artisan)
        {
            throw new NotFoundHttpException("  The artisan with the id n° ".$id." doesn't exist");
        }
        // create the form from the editformtype

        $form = $this->createForm(EditArtisanType::class, $artisan,array(
            'government' => $government
        ));
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
	 * @Route("/show-artisan/{id}", options={"expose"=true}, requirements={"id" = "\d+"},  name="artisan_show")
	 * @param $id
	 *
	 * @return Response
	 */
    public function showArtisan($id)
    {
        //  load the artisan from database
        $em = $this->getDoctrine()->getManager();
        $artisan = $em->getRepository(PM::class)->find($id);
        $user = $artisan->getUser();

        // test if the artisan exist else throw an exception
        if (null === $artisan)
        {
            throw new NotFoundHttpException("  The artisan with the id n° ".$id." doesn't exist");
        }


        return $this->render('artisan/show.html.twig', array(
            'artisan' => $artisan,
            'user' => $user
        ));
    }

	/**
	 * @Route("/print-recipe/{id}", name="printRecipe", requirements={"id"="\d+"})
	 * @param $id
	 *
	 * @return Response
	 */
    public function printRecipe($id)
    {
	    $em = $this->getDoctrine()->getManager();
	    $artisan = $em->getRepository('App:Artisan')->find($id);
	    $company = $em->getRepository('App:Company')->find($id);
        // get the template
	    if ($artisan !== null)
	    {
		    $template = $this->renderView('artisan/recipe.html.twig', array(
			    'artisan' => $artisan
		    ));
	    }
	    if ($company !== null)
	    {
		    $template = $this->renderView('artisan/recipe.html.twig', array(
			    'company' => $company
		    ));
	    }

        // initialise the service htmlToPdf from container
        $html2pdf = $this->get('recipe.html2pdf');
        // create the pdf with the bellow option
        $html2pdf->create('P', 'A4', 'fr', true, 'UTF-8', array(10,15,10,15));
        // return a generated pdf
        return $html2pdf->generatePdf($template, "recipe");

    }

	/**
	 * @Route("/confirm-print-recipe/{id}", name="confirmPrintRecipe")
	 * @param $id
	 *
	 * @return Response
	 */
    public function confirmPrintRecipe( $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$artisan = $em->getRepository('App:Artisan')->find($id);
    	$company = $em->getRepository('App:Company')->find($id);
    	if ( $artisan !== null)
	    {
		    // return a view with artisan instance to confirm print
		    return $this->render('artisan/confirm-print-recipe.html.twig', array(
			    'artisan' => $artisan,
		    ));
	    }
	    if ($company !== null)
	    {
		    // return a view with artisan instance to confirm print
		    return $this->render('artisan/confirm-print-recipe.html.twig', array(
			    'company' => $company
		    ));
	    }
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
     * @Method({"POST"})
     * @return Response
     */
    public function JsonArtisans(AuthorizationCheckerInterface $authorizationChecker)
    {

        $em = $this->getDoctrine()->getManager();
        // get the  user who is logged in
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // get the government of the use who is logged in
        $govUser = $user->getGovernment()->getId();

        // check if the current user has role_admin if yes he get all artisan result
        if (true === $authorizationChecker->isGranted('ROLE_ADMIN'))
        {
            $artisans = $em->getRepository(PM::class)->findBy( array('isDeleted' => '0'));

        }else {
            // use the method of repository getGovernmentUser
            // return the list of object artisan locate in the same ville of user ville.user = ville.artisan
            $artisans = $em->getRepository(PM::class)->getGovernmentUser($govUser);
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

    /**
     * @Route("/search", options={"expose"= true}, name="search_cin")
     * @param Request $request
     * @return Response
     * @Method({"POST"})
     */
    public function searchCin(Request $request)
    {
        $data = $request->get('input');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('App:Artisan')->getCin($data);
        $listCin = '<ul id="matchList">';
        foreach ($results as $result) {
            $stringBold = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result->getCin()); // Replace text field input by bold one
            $listCin .= '<li id="'.$result->getId().'" class="mb-10 ml-20"><i class="fa fa-genderless text-success mr-5"></i> '.$stringBold.'</li>'; // Create the matching list
        }
        $listCin .= '</ul>';

        $response = new JsonResponse();
        $response->setData(array('listCin' => $listCin));
        return $response;

    }

    /**
     * @Route("{id}/edit", options={"expose"=true}, name="modal_edit")
     * @param $id
     * @return JsonResponse
     */
    public function modalEditArtisan($id)
    {
        $em = $this->getDoctrine()->getManager();
        $artisan = $em->getRepository('App:Artisan')->find($id);
        $user = $artisan->getUser();
        $government = $user->getGovernment()->getId();
        $form = $this->createForm(EditArtisanType::class, $artisan,array(
            'government' => $government
        ));

        $temp = $this->renderView('modal/edit.html.twig', array(
            'artisan' => $artisan,
            'form' => $form->createView()
        ));
        $json = new JsonResponse(array(
            'content' => $temp
        ));
        return $json;
    }

    /**
     * @Route("/edit-artisan/{id}", options={"expose":true}, name="edit_artisan")
     * @Method({"POSt"})
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function editArtisan(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $artisan = $em->getRepository('App:Artisan')->find($id);

        if ($request->isXmlHttpRequest()) {
            $form = $this->createForm('App\Form\EditArtisanType', $artisan);
            $form->handleRequest($request);
            $em->persist($artisan);
            $em->flush();
            return new JsonResponse(array(
                'res' => 'loool'
            ));

        } else {
            return new JsonResponse(array('message' => 'Vous ne pouvez y accéder qu\'en utilisant Ajax!'), 400);
        }


    }


}
