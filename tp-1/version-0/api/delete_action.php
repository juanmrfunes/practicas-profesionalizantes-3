<?php
// api/delete_action.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$actionId = $data['actionId'];

if (!$actionId) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "DELETE FROM action WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $actionId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Action deleted']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
