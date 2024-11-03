<?php

namespace App\Controller\Api;


use App\Entity\ProjectsGroup;
use App\Form\ProjectsGroupFormType;
use App\Repository\ProjectsGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ProjectsGroupController extends AbstractController
{
    #[Route('api/project-groups', name: 'api_project_groups', methods: ['GET'], format: 'json')]
    public function get_project_groups(ProjectsGroupRepository $projectGroupRepository): JsonResponse
    {
        $project_groups = $projectGroupRepository->findAll();
        if (!$project_groups) {
            return $this->json(['data' => 'No projects found']);
        }
        return $this->json(['data' => $project_groups]);
    }

    #[Route('/api/project-groups/{id}', name: 'api_project_group', methods: ['GET'], format: 'json')]
    public function get_project_group(string $id, ProjectsGroupRepository $projectGroupRepository): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $project_group = $projectGroupRepository->find($uuid);
        if (!$project_group) {
            return $this->json(['data' => ['id' => 'Not found']], 404);
        }
        return $this->json(['data' => $project_group]);
    }

    #[Route('api/add/project-group', name: 'api_add_project_group', methods: ['POST'], format: 'json')]
    public function add_project_group(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $project_group = new ProjectsGroup();
        $data = json_decode($request->getContent(), true);
        $form = $this->CreateForm(ProjectsGroupFormType::class, $project_group);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($project_group);
            $em->flush();
            return $this->json(['data' => $project_group]);
        } else {
            $errors_list = $form->getConfig()->getType()->getInnerType()->customGetErrors($form);
            return $this->json(['data' => $errors_list], 400);
        }
    }

    #[Route('api/update/project-group/{id}', name: 'api_update_project_group', methods: ['PATCH'], format: 'json')]
    public function update_project(string $id, Request $request, EntityManagerInterface $em, ProjectsGroupRepository $projectGroupRepository): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $project_group = $projectGroupRepository->find($uuid);
        $data = json_decode($request->getContent(), true);
        $form = $this->CreateForm(ProjectsGroupFormType::class, $project_group);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $project_group->updateTimestamps();
            $em->persist($project_group);
            $em->flush();
            return $this->json(['data' => $project_group]);
        } else {
            $errors_list = $form->getConfig()->getType()->getInnerType()->customGetErrors($form);
            return $this->json(['data' => $errors_list], 400);
        }
    }

    #[Route('api/delete/project-group/{id}', name: 'api_delete_project_group', methods: ['DELETE'], format: 'json')]
    public function delete_project(string $id, ProjectsGroupRepository $projectRepository, EntityManagerInterface $em): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $project_group = $projectRepository->find($uuid);
        if (!$project_group) {
            $em->remove($project_group);
            $em->flush();
            $response = new JsonResponse();
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
            return $response;
        }
        return $this->json(['data' => ['id' => 'Not found']], 404);
    }
}
