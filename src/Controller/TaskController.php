<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Service\TaskService;
use App\Form\TaskType;
use App\Entity\Task;

final class TaskController extends AbstractController
{
     public function __construct(
        private TaskService $taskService
    ) {}

    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/task/add', name: 'app_task_add')]
    public function addTask(Request $request): Response
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $flash = $this->taskService->addTask($task);

            $this->addFlash($flash['type'], $flash['message']);

            return $this->redirectToRoute('app_task_list');
        }

        return $this->render('task/add_task.html.twig', ['form' => $form]);
    }

    #[Route('/task/list', name: 'app_task_list')]
    public function listTasks(TaskService $taskService): Response
    {
        $tasks = $taskService->listTasks();
        return $this->render('task/list_tasks.html.twig', ['tasks' => $tasks]);
    }
}
