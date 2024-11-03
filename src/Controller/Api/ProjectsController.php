<?php

namespace App\Controller\Api;


use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
            $project->updateTimestamps();
            $em->persist($project);
            $em->flush();
            return $this->json(['data' => $project]);
        } else {
            $errors_list = [];
            foreach ($form->getErrors() as $error) {
                $errors_list[$form->getName()][] = $error->getMessage();
            }
            foreach ($form as $child) {
                if (!$child->isValid()) {
                    foreach ($child->getErrors() as $error) {
                        $errors_list[$child->getName()][] = $error->getMessage();
                    }
                }
            }

            return $this->json(['data' => $errors_list], 400);
        }
    }
}
