<?php

namespace App\Controller;

use App\Entity\Juridique;
use App\Form\JuridiqueType;
use App\Repository\JuridiqueRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/juridique")
 * @Security("is_authenticated()")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class JuridiqueController extends Controller
{
    /**
     * @Route("/", name="juridique_index", methods="GET")
     * @param JuridiqueRepository $juridiqueRepository
     * @return Response
     */
    public function index(JuridiqueRepository $juridiqueRepository): Response
    {
        return $this->render('juridique/index.html.twig', ['juridiques' => $juridiqueRepository->findAll()]);
    }

    /**
     * @Route("/new", name="juridique_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $juridique = new Juridique();
        $form = $this->createForm(JuridiqueType::class, $juridique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($juridique);
            $em->flush();

            return $this->redirectToRoute('juridique_index');
        }

        return $this->render('juridique/new.html.twig', [
            'juridique' => $juridique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="juridique_show", methods="GET")
     * @param Juridique $juridique
     * @return Response
     */
    public function show(Juridique $juridique): Response
    {
        return $this->render('juridique/show.html.twig', ['juridique' => $juridique]);
    }

    /**
     * @Route("/{id}/edit", name="juridique_edit", methods="GET|POST")
     * @param Request $request
     * @param Juridique $juridique
     * @return Response
     */
    public function edit(Request $request, Juridique $juridique): Response
    {
        $form = $this->createForm(JuridiqueType::class, $juridique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('juridique_edit', ['id' => $juridique->getId()]);
        }

        return $this->render('juridique/edit.html.twig', [
            'juridique' => $juridique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="juridique_delete", methods="DELETE")
     * @param Request $request
     * @param Juridique $juridique
     * @return Response
     */
    public function delete(Request $request, Juridique $juridique): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$juridique->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('juridique_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($juridique);
        $em->flush();

        return $this->redirectToRoute('juridique_index');
    }
}
