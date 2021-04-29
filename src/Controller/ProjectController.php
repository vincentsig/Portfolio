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
    public function show(Project $project,ProjectRepository $repo): Response
    {
     
        $next = $repo->getNextProject($project->getId());
        $previous = $repo->getPreviousProject($project->getId());

        return $this->render(
            'project/show.html.twig',
            [
            "project" => $project,
            "slug" =>$project->getSlug(),
            "next" => $next,
            "previous" => $previous,
        ]
        );
    }
}
