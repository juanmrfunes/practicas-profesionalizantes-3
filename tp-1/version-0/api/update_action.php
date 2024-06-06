<?php
// api/update_action.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$actionId = $data['actionId'];
$actionName = $data['actionName'];

if (!$actionId || !$actionName) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "UPDATE action SET name = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $actionName, $actionId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Action updated']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
