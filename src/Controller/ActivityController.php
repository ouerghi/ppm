<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\Activity1Type;
use App\Repository\ActivityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity")
 * @Security("is_authenticated()")
 */
class ActivityController extends Controller
{
	/**
	 * @Route("/", name="activity_index", methods="GET")
	 * @Security("is_granted('ROLE_ADMIN')")
	 * @param ActivityRepository $activityRepository
	 *
	 * @return Response
	 */
    public function index(ActivityRepository $activityRepository): Response
    {
        return $this->render('activity/index.html.twig', ['activities' => $activityRepository->findAll()]);
    }

	/**
	 * @Route("/new", name="activity_new", methods="GET|POST")
	 * @param Request $request
	 *
	 * @return Response
	 */
    public function new(Request $request): Response
    {
        $activity = new Activity();
        $form = $this->createForm(Activity1Type::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();

            return $this->redirectToRoute('activity_index');
        }

        return $this->render('activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

	/**
	 * @Route("/{id}", name="activity_show", methods="GET")
	 * @param Activity $activity
	 *
	 * @return Response
	 */
    public function show(Activity $activity): Response
    {
        return $this->render('activity/show.html.twig', ['activity' => $activity]);
    }

	/**
	 * @Route("/{id}/edit", name="activity_edit", methods="GET|POST")
	 * @param Request $request
	 * @param Activity $activity
	 *
	 * @return Response
	 */
    public function edit(Request $request, Activity $activity): Response
    {
        $form = $this->createForm(Activity1Type::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activity_edit', ['id' => $activity->getId()]);
        }

        return $this->render('activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

	/**
	 * @Route("/{id}", name="activity_delete", methods="DELETE")
	 * @param Request $request
	 * @param Activity $activity
	 *
	 * @return Response
	 */
    public function delete(Request $request, Activity $activity): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$activity->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('activity_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($activity);
        $em->flush();

        return $this->redirectToRoute('activity_index');
    }
}
