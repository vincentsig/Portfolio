<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * SkillController 
 * @Route("/admin/skills")
 */
class SkillController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }   


    /**
     * @Route("/list", name="app_skill_list")
     */
    public function index(SkillRepository $repo): Response
    {
        return $this->render('skill/index.html.twig', [
            "skills" => $repo->findAll()            
        ]);
    }

    /**
     * @Route("/create", name="app_skill_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $skill = new Skill;
        $form = $this->createForm(SkillType::class, $skill)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($skill);
            $this->em->flush();
            $this->addFlash("success", "The skill has been added with success");

            return $this->redirectToRoute('app_skill_list');
        }
        
        return $this->render("skill/create.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="app_skill_edit")
     */
    public function edit(Request $request,Skill $skill)
    {
        $form = $this->createForm(SkillType::class, $skill)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($skill);
            $this->em->flush();
            $this->addFlash("success", "The skill has been edited with success");

            return $this->redirectToRoute('app_skill_list');
        }

        return $this->render("skill/Edit.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="app_skill_delete")
     */
    public function delete(Request $request, Skill $skill)
    {
   
        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->request->get('_token'))) {
            $this->em->remove($skill);
            $this->em->flush();
        }
        return $this->redirectToRoute('app_skill_list');
    }
}
