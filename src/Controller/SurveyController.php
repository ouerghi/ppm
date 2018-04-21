<?php

namespace App\Controller;

use App\Entity\Survey;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class SurveyController extends Controller
{
    /**
     * @Route("/survey", name="survey")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        // get the user
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $government = $user->getGovernment();
        $em = $this->getDoctrine()->getManager();
        $artisans = $em->getRepository('App:Artisan')->findBy(array('government' => $government));
        $users = $em->getRepository('App:User')->findBy(array('government' => $government));
       return $this->render('survey/index.html.twig', array(
           'artisans' => $artisans,
           'users' => $users,
       ));
    }
    /**
     * @Route("/all-survey", options={"expose":true}, name="json_survey")
     * @Method({"POST"})
     */
    public function getJsonSurvey()
    {
        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('App:Survey')->findAll();
        $event = array();
        foreach ($survey as $value)
        {
            $event[] = array(
                'id' => $value->getId(),
                'artisan' => $value->getArtisan()->getId(),
                'start' => $value->getStart()->format('Y-m-d H:i:s'),
                'end' => $value->getEnd()->format('Y-m-d H:i:s'),
                'title' => $value->getDescription(),
                'location' => $value->getArtisan()->getDelegation()->getName(),
                'allDay' => true,
                'class' => 'text-primary',
                'durationEditable' => true,
                'color' => 'yellow',
                'backgroundColor' => 'green',
                'borderColor' => 'white',
                'textColor' => 'brown'



            );
        }
        return new JsonResponse($event);
    }

    /**
     * @Route("/event", options={"expose":true}, name="event")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function EventSurvey(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $survey = new Survey();
        $form = $this->createForm('App\Form\SurveyType', $survey);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $artisan = $request->request->get('artisan');
            $user = $request->request->get('user');
            $artisan_event = $em->getRepository('App:Artisan')->find($artisan);
            $user_event = $em->getRepository('App:User')->find($user);
            $survey->setUser($user_event);
            $survey->setArtisan($artisan_event);
            $em->persist($survey);
            $em->flush();
            $this->addFlash('notice', "l'enquete a été bien enregistré ");
            return $this->redirectToRoute('survey');
        }
        $user = $request->get('user');
        $artisan = $request->get('artisan');
        $template = $this->renderView('modal/event.html.twig', array(
            'artisan'=>$artisan,
            'user' => $user,
            'form' => $form->createView()
        ));

        return new JsonResponse(array(
                'template' => $template
        ));
    }

}
