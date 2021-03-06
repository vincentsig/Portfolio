<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * ProjectController
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
        return $this->render("admin/project/index.html.twig", [
            "projects" => $repo->findAll()
        ]);
    }

    /**
     * @Route("/create", name="app_project_create")
     *
     * @param Request $request
     * @param FileUploader $uploader
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function create(Request $request, FileUploader $uploader, SluggerInterface $slugger): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uploader->upload($project->getMedia());

            $project->setSlug($slugger->slug($project->getSlug(), "-"));

            $this->em->persist($project->getMedia());
            $this->em->persist($project);
            $this->em->flush($project);

            return $this->redirectToRoute("app_project_list");
        }

        return $this->render("admin/project/create.html.twig", [
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
    public function edit(
        Request $request,
        Project $project,
        FileUploader $uploader,
        SluggerInterface $slugger,
        ProjectRepository $repo
    ): Response {
        $originalMedia = $repo->find($project)->getMedia()->getPath();
        $form = $this->createForm(ProjectType::class, $project)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getMedia()->getFile()) {
                $uploader->upload($project->getMedia());
                $uploader->removeFile($originalMedia);
            }

            $project->setSlug($slugger->slug($project->getSlug(), "-"));

            $this->em->persist($project->getMedia());
            $this->em->persist($project);
            $this->em->flush();




            return $this->redirectToRoute("app_project_list");
        }

        return $this->render("admin/project/edit.html.twig", [
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
