<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/admin/", name="app_dashboard_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('/admin/dashboard/index.html.twig');
    }
}
