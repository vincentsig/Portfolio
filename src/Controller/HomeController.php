<?php

namespace App\Controller;

use App\Service\MailerService;
use App\Repository\SkillRepository;
use App\Repository\TechnoRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(
        SkillRepository $skillRepository,
        ProjectRepository $projectRepository,
        TechnoRepository $technoRepository,
        MailerService $mailer,
        Request $request
    ): Response {
        if ($mailer->sendEmail($request)) {
            $this->addFlash('success', 'Your message has been sent');

            return $this->redirectToRoute("app_home");
        }

        return $this->render('home/index.html.twig', [
            'skills' => $skillRepository->findAll(),
            'projects' => $projectRepository->findAll(),
            'technos' => $technoRepository->findAll(),
            'form' => $mailer->getForm()->createView()
        ]);
    }
}
