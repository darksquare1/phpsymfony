<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

abstract class BaseApiController extends AbstractController
{
    protected function handleAdd(Request $request, EntityManagerInterface $em, string $formType, object $entity): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm($formType, $entity);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->json(['data' => $entity]);
        } else {
            $errors_list = $form->getConfig()->getType()->getInnerType()->customGetErrors($form);

            return $this->json(['data' => $errors_list], 400);
        }
    }

    protected function handleUpdate(string $id, Request $request, EntityManagerInterface $em, string $formType, ObjectRepository $repository): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $entity = $repository->find($uuid);

        if (!$entity) {
            return $this->json(['data' => ['id' => 'Not found']], 404);
        }
        $entity->updateTimestamps();

        return $this->handleAdd($request, $em, $formType, $entity);
    }

    protected function handleDelete(string $id, EntityManagerInterface $em, ObjectRepository $repository): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $entity = $repository->find($uuid);

        if (!$entity) {
            return $this->json(['data' => ['id' => 'Not found']], 404);
        }

        $em->remove($entity);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    protected function handleGet(string $id, ObjectRepository $repository, $dtoFactory): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $entity = $repository->find($uuid);

        if (!$entity) {
            return $this->json(['data' => ['id' => 'Not found']], 404);
        }
        $dto = $dtoFactory->createFromEntity($entity);

        return $this->json(['data' => $dto]);
    }

    protected function handleGetAll(ObjectRepository $repository, $dtoFactory): JsonResponse
    {
        $entities = $repository->findAll();
        $dtos = $dtoFactory->createFromEntities($entities);

        return $this->json(['data' => $dtos]);
    }
}
