<?php

namespace App\Controller\Admin;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * TechnoController
 * @Route("/admin/technos")
 */
class TechnoController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/list", name="app_techno_list")
     *
     * @param TechnoRepository $repo
     * @return Response
     */
    public function index(TechnoRepository $repo): Response
    {
        return $this->render("admin/techno/index.html.twig", [
            'technos' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="app_techno_create")
     *
     * @param Request $request
     * @return Response $reponse
     */
    public function create(Request $request): Response
    {
        $techno = new Techno();

        $form = $this->createForm(TechnoType::class, $techno)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($techno);
            $this->em->flush();

            $this->addFlash("success", "The techno has been added with success");

            return $this->redirectToRoute('app_techno_list');
        }

        return $this->render('admin/techno/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_techno_edit")
     *
     * @param Request $request
     * @param Techno $techno
     * @return Response $reponse
     */
    public function edit(Request $request, Techno $techno): Response
    {
        $form = $this->createForm(TechnoType::class, $techno)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($techno);
            $this->em->flush();

            return $this->redirectToRoute('app_techno_list');
        }

        return $this->render('techno/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_techno_delete")
     *
     * @param Request $request
     * @param Techno $techno
     * @return Response
     */
    public function delete(Request $request, Techno $techno): Response
    {
        if ($this->isCsrfTokenValid('delete' . $techno->getId(), $request->request->get('_token'))) {
            $this->em->remove($techno);
            $this->em->flush();

            $this->addFlash("success", "The techno has been deleted with success");
        }

        return $this->redirectToRoute('app_techno_list');
    }
}
