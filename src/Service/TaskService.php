<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{

    public function __construct(
        private TaskRepository $taskRepository,
        private EntityManagerInterface $em
    ) {}

    public function addTask(Task $task): array
    {
        //Test si la tache existe
        if (!$task) {
            return ["type" => "warning", "message" => "La tache n'existe pas"];
        }

        //test si la task existe déja
        if ($this->taskRepository->findOneBy(["title" => $task->getTitle()])) {
            return ["type" => "danger", "message" => "La tache existe déjà"];
        }
        //Ajout en BDD
        $this->em->persist($task);
        $this->em->flush();

        return ["type"=>"success", "message"=> "La tache a été ajoutée"];
    }

    public function listTasks(): array
    {
        try {
            $tasks = $this->taskRepository->findAll();
        } catch (\Throwable $th) {
            throw new \Exception("Erreur lors de la récupération des tâches : " . $th->getMessage());
        }
        
        return $tasks;
    }
}
