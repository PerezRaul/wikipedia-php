<?php

require_once 'HistoryService.php';

$service = new HistoryService();
$action  = $_GET['action'];

if ($action === 'save') {
    $data = json_decode(file_get_contents('php://input'), true);

    $result = $service->save($data);

    echo json_encode(['message' => $result]);
} else {
    echo json_encode(['message' => 'Invalid action']);
}