<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(SkillRepository $skillRepository, ProjectRepository $projectRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'skills' => $skillRepository->findAll(),
            'projects' => $projectRepository->findAll(),
        ]);
    }
}
