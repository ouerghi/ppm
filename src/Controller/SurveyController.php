<?php

namespace App\Controller;

use App\Entity\PM;
use App\Entity\Survey;
use App\Form\SurveyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;




class SurveyController extends Controller
{
	/**
	 * @Route("/survey", name="survey")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @throws \Exception
	 */
    public function index(Request $request)
    {
        // get the user
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $government = $user->getGovernment();
        $em = $this->getDoctrine()->getManager();
        $pm = $em->getRepository(PM::class)->findBy(array('government' => $government));
        $users = $em->getRepository('App:User')->findByRoleByGovernment($government, 'ROLE_DRC');
        $survey = new Survey();
        $form = $this->createForm(SurveyType::class, $survey, array(
        	'government' => $government
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
        	$start = $survey->getStart();
        	$end = $survey->getEnd();
        	if ($start > $end)
	         {
	        	throw new \Exception('La date de début ne peut pas etre supérieur à la date de fin');
	         }
        	$survey->setUser($user);
        	$em->persist($survey);
        	$em->flush();
	       $this->addFlash('notice', 'Votre enquete à été bien enregistré');
	       return $this->redirectToRoute('list-survey');
        }
       return $this->render('survey/index.html.twig', array(
           'PM' => $pm,
           'users' => $users,
	       'form' => $form->createView()
       ));
    }

	/**
	 * @Route("/list-survey", name="list-survey")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function listSurvey(Request $request)
    {

	    $em    = $this->get('doctrine.orm.entity_manager');
	    $dql   = "SELECT s FROM App\Entity\Survey s  ";
	    $query = $em->createQuery($dql);

	    $paginator  = $this->get('knp_paginator');
	    $survey = $paginator->paginate(
		    $query, /* query NOT result */
		    $request->query->getInt('page', 1),
		    5
	    );
    	return $this->render('survey/list.html.twig', array(
    		'survey' => $survey
	    ));

    }

	/**
	 * @Route("/print/{id}", name="print-survey")
	 * @param $id
	 *
	 * @return view
	 */
    public function printSurvey($id)
    {
    	$template = '';
    	$em = $this->getDoctrine()->getManager();
    	$user = $em->getRepository('App:User')->find($id);
    	if ($user !== null)
	    {
	    	$template = $this->renderView('survey/survey.html.twig', array(
	    		'user' => $user
		    ));
	    }

	    // initialise the service htmlToPdf from container
	    $html2pdf = $this->get('recipe.html2pdf');
	    // create the pdf with the bellow option
	    $html2pdf->create('P', 'A4', 'fr', true, 'UTF-8', array(10,15,10,15));
	    // return a generated pdf
	    return $html2pdf->generatePdf($template, "enquete");

    }
	/**
	 * @Route("/tert", name="tert")
	 */
    public function tert()
    {
    	$em = $this->getDoctrine()->getManager();
    	$sur = $em->getRepository('App:Survey')->find(1);

    	$all=  $sur->getUsers();
    	foreach ($all as $value)
	    {
	    	echo $value->getUsername().'<br>';
	    }
    	die();
    }

}
