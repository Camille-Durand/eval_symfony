<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository) 
    {
        $this->taskRepository = $taskRepository;
    }

    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/task/add', name: 'app_task_add')]
    public function addTask(Request $request, EntityManagerInterface $emi, TaskRepository $taskRepository): Response
    {
        $msg = "";
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            if(!$taskRepository->findOneBy(['title'=>$task->getTitle(), 'content'=>$task->getContent()])){
                $emi->persist($task);
                $emi->flush();
                $msg="La task a bien été ajouté dans la BDD";
            } else {
                $msg = "La task existe déjà";
            }
        }
        return $this->render('task/index.html.twig', [
            'form' => $form->createView(),
            'msg' => $msg
        ]);
    }

    #[Route('/task/all', name: 'app_task_all')]
    public function allTasks(): Response
    {
        $tasks = $this->taskRepository->findAll();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
