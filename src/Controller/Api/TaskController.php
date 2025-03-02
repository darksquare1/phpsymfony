<?php


namespace App\Controller\Api;


use App\Entity\Task;
use App\Factory\TaskFactory;
use App\Form\TaskFormType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class TaskController extends BaseApiController
{
    #[Route('/tasks', name: 'api_tasks', methods: ['GET'], format: 'json')]
    public function getTasks(TaskRepository $taskRepository, TaskFactory $taskDTOFactory): JsonResponse
    {
        return $this->handleGetAll($taskRepository, $taskDTOFactory);
    }

    #[Route('/tasks/{id}', name: 'api_task', methods: ['GET'], format: 'json')]
    public function getTask(string $id, TaskRepository $taskRepository, TaskFactory $taskDTOFactory): JsonResponse
    {
        return $this->handleGet($id, $taskRepository, $taskDTOFactory);
    }

    #[Route('/add/task', name: 'api_add_task', methods: ['POST'], format: 'json')]
    public function addTask(Request $request, EntityManagerInterface $em): JsonResponse
    {
        return $this->handleAdd($request, $em, TaskFormType::class, new Task());
    }

    #[Route('/update/task/{id}', name: 'api_update_task', methods: ['PATCH'], format: 'json')]
    public function updateTask(string $id, Request $request, EntityManagerInterface $em, TaskRepository $taskRepository): JsonResponse
    {
        return $this->handleUpdate($id, $request, $em, TaskFormType::class, $taskRepository);
    }

    #[Route('/delete/task/{id}', name: 'api_delete_task', methods: ['DELETE'], format: 'json')]
    public function deleteTask(string $id, TaskRepository $taskRepository, EntityManagerInterface $em): JsonResponse
    {
        return $this->handleDelete($id, $em, $taskRepository);
    }
}
