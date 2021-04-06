<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SkillController extends AbstractController
{
    
    /**
     * @Route("/skill", name="skill")
     */
    public function index(SkillRepository $repo ): Response
    {
        return $this->render('skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }
}
