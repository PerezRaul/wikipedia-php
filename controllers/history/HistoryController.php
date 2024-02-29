<?php

require_once '../../models/history/History.php';

$model  = new History();
$action = $_GET['action'];

if ($action === 'save') {
    $data = json_decode(file_get_contents('php://input'), true);

    $result = $model->save($data);

    echo json_encode(['message' => $result]);
} else {
    echo json_encode(['message' => 'Invalid action']);
}