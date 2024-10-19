<?php

namespace App\Controller;


use App\Repository\ProjectRepository;
use App\Repository\ProjectsGroupRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(ProjectRepository $projectRepository, ProjectsGroupRepository $projectsGroupRepository,
                          TaskRepository    $taskRepository): Response
    {
        $projects = $projectRepository->findAll();
        $project_groups = $projectsGroupRepository->findAll();
        $tasks = $taskRepository->findAll();
        return $this->render('default/index.html.twig', [
            'projects' => $projects,
            'project_groups' => $project_groups,
            'tasks' => $tasks,
        ]);
    }
}
