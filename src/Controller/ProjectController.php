<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/projects")
 */
class ProjectController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/list", name="app_project_list")
     *
     * @param ProjectRepository $repo
     * @return Response
     */
    public function index(ProjectRepository $repo): Response
    {
        return $this->render("project/index.html.twig", [
            "projects" => $repo->findAll()
        ]);
    }

    /**
     * @Route("/create", name="app_project_create")
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request, FileUploader $uploader): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
    
            $uploader->upload($project->getMedia());
            
            $this->em->persist($project->getMedia());
            $this->em->persist($project);
            $this->em->flush($project);

            return $this->redirectToRoute("app_project_list");
        }

        return $this->render("project/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_project_edit")
     *
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function edit(Request $request, Project $project): Response
    {

        $form = $this->createForm(ProjectType::class, $project)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($project);
            $this->em->flush($project);
        }

        return $this->render("project/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
    *@Route("/delete/{id}", name="app_project_delete") 
    *
    * @param Request $request 
    * @param Project $projet 
    * @return Response
    */ 
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {

            $this->em->remove($project);
            $this->em->flush();

            $this->addFlash("success", "The project has been removed with success");
        }
        return $this->redirectToRoute('app_project_list');
    }
}
