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
    #[Route('api/projects', name: 'api_projects', methods: ['GET'], format: 'json')]
    public function get_projects(ProjectRepository $projectRepository): JsonResponse
    {
        return $this->handleGetAll($projectRepository);
    }

    #[Route('/api/projects/{id}', name: 'api_project', methods: ['GET'], format: 'json')]
    public function get_project(string $id, ProjectRepository $projectRepository): JsonResponse
    {
        return $this->handleGet($id, $projectRepository);
    }

    #[Route('api/add/project', name: 'api_add_project', methods: ['POST'], format: 'json')]
    public function add_project(Request $request, EntityManagerInterface $em): JsonResponse
    {
        return $this->handleAdd($request, $em, ProjectFormType::class, new Project());
    }

    #[Route('api/update/project/{id}', name: 'api_update_project', methods: ['PATCH'], format: 'json')]
    public function update_project(string $id, Request $request, EntityManagerInterface $em, ProjectRepository $projectRepository): JsonResponse
    {
        return $this->handleUpdate($id, $request, $em, ProjectFormType::class, $projectRepository);
    }

    #[Route('api/delete/project/{id}', name: 'api_delete_project', methods: ['DELETE'], format: 'json')]
    public function delete_project(string $id, ProjectRepository $projectRepository, EntityManagerInterface $em): JsonResponse
    {
        return $this->handleDelete($id, $em, $projectRepository);
    }
}
