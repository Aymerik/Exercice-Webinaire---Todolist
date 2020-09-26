<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/tasks")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="get_tasks")
     */
    public function getTasks(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findAll();

        return $this->json($tasks, Response::HTTP_OK, [], ['groups' => 'list_task']);
    }

    /**
     * @Route("/", methods={"POST"}, name="post_task")
     */
    public function postTask(SerializerInterface $serializer, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        try {
            $task = $serializer->deserialize($request->getContent(), Task::class, 'json');
        } catch(NotEncodableValueException $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        $errors = $validator->validate($task);

        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->json($task, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get_task")
     */
    public function getTask(Task $task)
    {
        return $this->json($task);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete_task")
     */
    public function deleteTask(Task $task, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($task);
        $entityManager->flush();

        return $this->json(["message" => "Task deleted!"], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="edit_task")
     */
    public function editTask(Task $task, SerializerInterface $serializer, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        try {
            $editedTask = $serializer->deserialize($request->getContent(), Task::class, 'json');
        } catch(NotEncodableValueException $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        $errors = $validator->validate($editedTask);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $task->setTitle($editedTask->getTitle())
            ->setDone($editedTask->isDone());

        $entityManager->flush();

        return $this->json($task, Response::HTTP_OK);
    }
}