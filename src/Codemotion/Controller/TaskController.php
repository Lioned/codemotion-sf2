<?php

namespace Codemotion\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Codemotion\Model\TaskManager;
use Codemotion\Model\Item;

class TaskController extends Controller
{
    public function listAction(Request $request)
    {
        $taskManager = $this->get('codemotion.task_manager');

        if ($name = $request->get('name')) {
            $tasks = $taskManager->getByName($name);
        } else {
            $tasks = $taskManager->getAll();
        }

        return $this->renderView('list', array('tasks' => $tasks));
    }

    public function showAction(Request $request)
    {
        $taskManager = $this->get('codemotion.task_manager');
        $task = $taskManager->getOneByName($request->get('name'));

        return $this->renderView('show', array('task' => $task));
    }

    public function deleteAction(Request $request)
    {
        $taskManager = $this->get('codemotion.task_manager');
        $task = $taskManager->getOneByName($request->get('name'));

        $taskManager->deleteTask($task);

        return new RedirectResponse('/app.php/task/list');
    }

    public function createAction(Request $request)
    {
        $taskManager = $this->get('codemotion.task_manager');

        $task = $taskManager->createTask('Tarea ' . uniqid(), "Descripción ...");

        /*  Asociación de items */
        $randomItems = array(
            'Subtarea ' . uniqid(),
            'Subtarea ' . uniqid(),
            'Subtarea ' . uniqid()
        );

        foreach ($randomItems as $itemName) {
            // Cascade = "all" --> Los items se guardarán cuando se guarda la tarea.
            $item = new Item();
            $item->setName($itemName);

            /* Relacción bidireccional */
            $item->setTask($task);
            $task->addItem($item);
        }

        $taskManager->updateTask($task);

        return new RedirectResponse('/app.php/task/list');
    }
}
