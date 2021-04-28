<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project/{slug}", name="app_project_show")
     *
     * @param ProjectRepository $repo
     * @param Project $project
     * @return Response
     */
    public function show(Project $project): Response
    {
        

        return $this->render(
            'project/show.html.twig',
            [
            "project" => $project,
            "slug" =>$project->getSlug(),
        ]
        );
    }

    /**
     * @Route("/projects", name="app_list")
     *  
     */
    public function index(ProjectRepository $repo, Request $request): Response
    {
        $limit = 1;

        $page = $request->query->get("page", 1);
        $projects = $repo->getPaginatedAnnonces($page, $limit);
        $totalProjects = count($repo->findAll());


        return $this->render(
            'project/show.html.twig',
            [
            "projects" => $projects,
            "page" => $page,
            "total" => $totalProjects,
            "limit" => $limit,
            
            
        ]
        );
    }


}
