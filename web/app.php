<?php

require_once __DIR__ . '/../app/autoload.php';

use Codemotion\Model\TaskManager;

// Recogemos los datos
$taskManager = new TaskManager();

if (isset($_GET['name']) && '' !== $_GET['name']) {
    $tasks = $taskManager->getByName($_GET['name']);
} else {
    $tasks = $taskManager->getAll();
}

/* Enviamos la cabecera HTTP con estado OK (200) */
header('HTTP 1.0 200 OK');
header('Content-Type: text/html UTF-8');
$now = new \DateTime();
header(sprintf('date: /%s ', $now->format("Y-m-d H:i:s")));

/* Enviamos el contenido HTTP */
include __DIR__ . '/../src/Codemotion/View/Task/list.php';
