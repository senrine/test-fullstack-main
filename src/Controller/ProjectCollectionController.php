<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\CreateProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projects')]
class ProjectCollectionController extends
    AbstractController
{

    /**
     * @param \App\Repository\ProjectRepository $projectRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/', name: 'app_Project_list', methods: ['GET'])]
    public function listProjects(ProjectRepository $projectRepository) : Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('app/Project/list.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/create', name: 'app_Project_create', methods: ['POST', 'GET'])]
    public function createProject(ProjectRepository $projectRepository, Request $request, EntityManagerInterface $entityManager) : Response
    {
        $form = $this->createForm(CreateProjectType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $project = $form->getData();
           $entityManager->persist($project);
           $entityManager->flush();

           return $this->redirectToRoute('app_Project_list');
        }

        $formView = $form->createView();

        return $this->render('app/Project/create.html.twig', [
            'form' => $formView,
        ]);
    }


}
