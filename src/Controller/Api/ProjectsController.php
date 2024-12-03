<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProjectsController extends BaseApiController
{
    #[Route('/projects', name: 'api_projects', methods: ['GET'], format: 'json')]
    public function getProjects(ProjectRepository $projectRepository): JsonResponse
    {
        return $this->handleGetAll($projectRepository);
    }

    #[Route('/projects/{id}', name: 'api_project', methods: ['GET'], format: 'json')]
    public function getProject(string $id, ProjectRepository $projectRepository): JsonResponse
    {
        return $this->handleGet($id, $projectRepository);
    }

    #[Route('/add/project', name: 'api_add_project', methods: ['POST'], format: 'json')]
    public function addProject(Request $request, EntityManagerInterface $em): JsonResponse
    {
        return $this->handleAdd($request, $em, ProjectFormType::class, new Project());
    }

    #[Route('/update/project/{id}', name: 'api_update_project', methods: ['PATCH'], format: 'json')]
    public function updateProject(string $id, Request $request, EntityManagerInterface $em, ProjectRepository $projectRepository): JsonResponse
    {
        return $this->handleUpdate($id, $request, $em, ProjectFormType::class, $projectRepository);
    }

    #[Route('/delete/project/{id}', name: 'api_delete_project', methods: ['DELETE'], format: 'json')]
    public function deleteProject(string $id, ProjectRepository $projectRepository, EntityManagerInterface $em): JsonResponse
    {
        return $this->handleDelete($id, $em, $projectRepository);
    }
}
