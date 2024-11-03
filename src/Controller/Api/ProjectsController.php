<?php

namespace App\Controller\Api;


use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ProjectsController extends AbstractController
{
    #[Route('api/projects', name: 'api_projects', methods: ['GET'], format: 'json')]
    public function get_projects(ProjectRepository $projectRepository): JsonResponse
    {
        $projects = $projectRepository->findAll();
        return $this->json(['data' => $projects]);
    }

    #[Route('/api/projects/{id}', name: 'api_project', methods: ['GET'], format: 'json')]
    public function get_project(string $id, ProjectRepository $projectRepository): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $project = $projectRepository->find($uuid);
        return $this->json(['data' => $project]);
    }

    #[Route('api/add/project', name: 'api_add_project', methods: ['POST'], format: 'json')]
    public function add_project(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $project = new Project();
        $data = json_decode($request->getContent(), true);
        $form = $this->CreateForm(ProjectFormType::class, $project);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($project);
            $em->flush();
            return $this->json(['data' => $project]);
        } else {
            $errors_list = $form->getConfig()->getType()->getInnerType()->customGetErrors($form);
            return $this->json(['data' => $errors_list], 400);
        }
    }

    #[Route('api/update/project/{id}', name: 'api_update_project', methods: ['PATCH'], format: 'json')]
    public function update_project(string $id, Request $request, EntityManagerInterface $em, ProjectRepository $projectRepository): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $project = $projectRepository->find($uuid);
        $data = json_decode($request->getContent(), true);
        $form = $this->CreateForm(ProjectFormType::class, $project);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $project->updateTimestamps();
            $em->persist($project);
            $em->flush();
            return $this->json(['data' => $project]);
        } else {
            $errors_list = $form->getConfig()->getType()->getInnerType()->customGetErrors($form);
            return $this->json(['data' => $errors_list], 400);
        }
    }

    #[Route('api/delete/project/{id}', name: 'api_delete_project', methods: ['DELETE'], format: 'json')]
    public function delete_project(string $id, ProjectRepository $projectRepository, EntityManagerInterface $em): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $project = $projectRepository->find($uuid);
        if ($project !== null) {
            $em->remove($project);
            $em->flush();
            $response = new JsonResponse();
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
            return $response;
        }
        return $this->json(['data' => ['id'=>'Not found']], 404);
    }
}
