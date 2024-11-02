<?php

namespace App\Controller\Api;


use App\Repository\ProjectRepository;
use App\Repository\ProjectsGroupRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('api/projects', name: 'api_projects', methods: ['GET'])]
    public function get_projects(ProjectRepository $projectRepository): JsonResponse
    {
        $projects = $projectRepository->findAll();
        return $this->json(['data' => $projects]);
    }
}
