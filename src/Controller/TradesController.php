<?php

namespace App\Controller;

use App\Entity\Trades;
use App\Form\TradesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trades")
 */
class TradesController extends Controller
{
    /**
     * @Route("/", name="trades_index", methods="GET")
     */
    public function index(): Response
    {
        $trades = $this->getDoctrine()
            ->getRepository(Trades::class)
            ->findAll();

        return $this->render('trades/index.html.twig', ['trades' => $trades]);
    }

    /**
     * @Route("/new", name="trades_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $trade = new Trades();
        $form = $this->createForm(TradesType::class, $trade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trade);
            $em->flush();

            return $this->redirectToRoute('trades_index');
        }

        return $this->render('trades/new.html.twig', [
            'trade' => $trade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trades_show", methods="GET")
     */
    public function show(Trades $trade): Response
    {
        return $this->render('trades/show.html.twig', ['trade' => $trade]);
    }

    /**
     * @Route("/{id}/edit", name="trades_edit", methods="GET|POST")
     */
    public function edit(Request $request, Trades $trade): Response
    {
        $form = $this->createForm(TradesType::class, $trade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trades_edit', ['id' => $trade->getId()]);
        }

        return $this->render('trades/edit.html.twig', [
            'trade' => $trade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trades_delete", methods="DELETE")
     */
    public function delete(Request $request, Trades $trade): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$trade->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('trades_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($trade);
        $em->flush();

        return $this->redirectToRoute('trades_index');
    }
}
