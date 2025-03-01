<?php

namespace App\Controller;

use App\Entity\ProjectsGroup;
use App\Form\ProjectsGroupFormType;
use App\Repository\ProjectsGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projects/group')]
class ProjectsGroupController extends AbstractController
{
    #[Route('/', name: 'app_projects_group_index', methods: ['GET'])]
    public function index(ProjectsGroupRepository $projectsGroupRepository): Response
    {
        return $this->render('projects_group/index.html.twig', [
            'projects_groups' => $projectsGroupRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_projects_group_show', methods: ['GET'])]
    public function show(ProjectsGroup $projectsGroup): Response
    {
        return $this->render('projects_group/show.html.twig', [
            'projects_group' => $projectsGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_projects_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProjectsGroup $projectsGroup, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectsGroupFormType::class, $projectsGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_projects_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('projects_group/edit.html.twig', [
            'projects_group' => $projectsGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projects_group_delete', methods: ['POST'])]
    public function delete(Request $request, ProjectsGroup $projectsGroup, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $projectsGroup->getId(), $request->request->get('_token'))) {
            $entityManager->remove($projectsGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_projects_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
