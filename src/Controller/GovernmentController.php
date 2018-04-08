<?php

namespace App\Controller;

use App\Entity\Government;
use App\Form\GovernmentType;
use App\Repository\GovernmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/government")
 */
class GovernmentController extends Controller
{
    /**
     * @Route("/", name="government_index", methods="GET")
     * @param GovernmentRepository $governmentRepository
     * @return Response
     */
    public function index(GovernmentRepository $governmentRepository): Response
    {
        return $this->render('government/index.html.twig', ['governments' => $governmentRepository->findAll()]);
    }

    /**
     * @Route("/new", name="government_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $government = new Government();
        $form = $this->createForm(GovernmentType::class, $government);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($government);
            $em->flush();

            return $this->redirectToRoute('government_index');
        }

        return $this->render('government/new.html.twig', [
            'government' => $government,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="government_show", methods="GET")
     * @param Government $government
     * @return Response
     */
    public function show(Government $government): Response
    {
        return $this->render('government/show.html.twig', ['government' => $government]);
    }

    /**
     * @Route("/{id}/edit", name="government_edit", methods="GET|POST")
     * @param Request $request
     * @param Government $government
     * @return Response
     */
    public function edit(Request $request, Government $government): Response
    {
        $form = $this->createForm(GovernmentType::class, $government);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('government_edit', ['id' => $government->getId()]);
        }

        return $this->render('government/edit.html.twig', [
            'government' => $government,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="government_delete", methods="DELETE")
     * @param Request $request
     * @param Government $government
     * @return Response
     */
    public function delete(Request $request, Government $government): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$government->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('government_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($government);
        $em->flush();

        return $this->redirectToRoute('government_index');
    }
}
