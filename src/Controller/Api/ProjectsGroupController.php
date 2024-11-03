<?php

namespace App\Controller\Api;

use App\Entity\ProjectsGroup;
use App\Form\ProjectsGroupFormType;
use App\Repository\ProjectsGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsGroupController extends BaseApiController
{
    #[Route('api/project-groups', name: 'api_project_groups', methods: ['GET'], format: 'json')]
    public function get_project_groups(ProjectsGroupRepository $projectGroupRepository): JsonResponse
    {
        return $this->handleGetAll($projectGroupRepository);
    }

    #[Route('/api/project-groups/{id}', name: 'api_project_group', methods: ['GET'], format: 'json')]
    public function get_project_group(string $id, ProjectsGroupRepository $projectGroupRepository): JsonResponse
    {
        return $this->handleGet($id, $projectGroupRepository);
    }

    #[Route('api/add/project-group', name: 'api_add_project_group', methods: ['POST'], format: 'json')]
    public function add_project_group(Request $request, EntityManagerInterface $em): JsonResponse
    {
        return $this->handleAdd($request, $em, ProjectsGroupFormType::class, new ProjectsGroup());
    }

    #[Route('api/update/project-group/{id}', name: 'api_update_project_group', methods: ['PATCH'], format: 'json')]
    public function update_project_group(string $id, Request $request, EntityManagerInterface $em, ProjectsGroupRepository $projectGroupRepository): JsonResponse
    {
        return $this->handleUpdate($id, $request, $em, ProjectsGroupFormType::class, $projectGroupRepository);
    }

    #[Route('api/delete/project-group/{id}', name: 'api_delete_project_group', methods: ['DELETE'], format: 'json')]
    public function delete_project_group(string $id, ProjectsGroupRepository $projectRepository, EntityManagerInterface $em): JsonResponse
    {
        return $this->handleDelete($id, $em, $projectRepository);
    }
}
