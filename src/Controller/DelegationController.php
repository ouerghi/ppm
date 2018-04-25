<?php

namespace App\Controller;

use App\Entity\Delegation;
use App\Form\DelegationType;
use App\Repository\DelegationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/delegation")
 */
class DelegationController extends Controller
{
    /**
     * @Route("/", name="delegation_index", methods="GET")
     * @param DelegationRepository $delegationRepository
     * @param Request $request
     * @return Response
     */
    public function index(DelegationRepository $delegationRepository, Request $request): Response
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT d FROM App\Entity\Delegation d  ";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('delegation/index.html.twig', ['delegations' => $pagination]);
    }

    /**
     * @Route("/new", name="delegation_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $delegation = new Delegation();
        $form = $this->createForm(DelegationType::class, $delegation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($delegation);
            $em->flush();

            return $this->redirectToRoute('delegation_index');
        }

        return $this->render('delegation/new.html.twig', [
            'delegation' => $delegation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delegation_show", methods="GET")
     * @param Delegation $delegation
     * @return Response
     */
    public function show(Delegation $delegation): Response
    {
        return $this->render('delegation/show.html.twig', ['delegation' => $delegation]);
    }

    /**
     * @Route("/{id}/edit", name="delegation_edit", methods="GET|POST")
     * @param Request $request
     * @param Delegation $delegation
     * @return Response
     */
    public function edit(Request $request, Delegation $delegation): Response
    {
        $form = $this->createForm(DelegationType::class, $delegation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =  $this->getDoctrine()->getManager();
            $em->merge($delegation);
            $em->flush();

            return $this->redirectToRoute('delegation_edit', ['id' => $delegation->getId()]);
        }

        return $this->render('delegation/edit.html.twig', [
            'delegation' => $delegation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delegation_delete", methods="DELETE")
     * @param Request $request
     * @param Delegation $delegation
     * @return Response
     */
    public function delete(Request $request, Delegation $delegation): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$delegation->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('delegation_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($delegation);
        $em->flush();

        return $this->redirectToRoute('delegation_index');
    }
}
