<?php

require_once 'HistoryService.php';

$action = $_GET['action'];

$service = new HistoryService();


if ($action === 'save') {
    $data = json_decode(file_get_contents('php://input'), true);

    $result = $service->save($data);

    echo json_encode($result);
    //$data = json_decode(file_get_contents('php://input'), true);
    //$controller->guardarHistorial($data);
} else {
    echo json_encode(['data' => 'Invalid action']);
}