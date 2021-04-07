<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use App\Service\FileUploader;
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
     * @param SkillRepository $repo
     * @return Response
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
    public function create(Request $request, FileUploader $uploader): Response
    {
        $skill = new Skill;
        
        $form = $this->createForm(SkillType::class, $skill)->handleRequest($request);
      
        if ($form->isSubmitted() && $form->isValid()) {
            
            $uploader->upload($skill->getMedia());

            $this->em->persist($skill->getMedia());
            $this->em->persist($skill);
            $this->em->flush();

            $this->addFlash("success", "The skill has been added with success");

            return $this->redirectToRoute('app_skill_list');
        }
        
        return $this->render("skill/create.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="app_skill_edit")
     * @param Request $request
     * @param Skill $skill
     * @return Response
     */
    public function edit(Request $request, Skill $skill, FileUploader $uploader): Response
    {
        $form = $this->createForm(SkillType::class, $skill)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploader->upload($skill->getMedia());

            $this->em->persist($skill);
            $this->em->flush();

            $this->addFlash("success", "The skill has been edited with success");

            return $this->redirectToRoute('app_skill_list');
        }

        return $this->render("skill/Edit.html.twig", [
            "form" => $form->createView(),
            "skill" => $skill,
            ]);
    }

    /**
     * @Route("/delete/{id}", name="app_skill_delete")
     * @param Request $request
     * @param Skill $skill
     * @return Response
     */
    public function delete(Request $request, Skill $skill, FileUploader $uploader): Response
    {
       
        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->request->get('_token'))) {
            $uploader->removeFile($skill->getMedia());
            $this->em->remove($skill);
            $this->em->flush();

            $this->addFlash("success", "The skill has been removed with success");
        }
        return $this->redirectToRoute('app_skill_list');
    }
}
