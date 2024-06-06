<?php
// api/add_action.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$actionName = $data['actionName'];

if (!$actionName) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "INSERT INTO action (name) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $actionName);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Action added']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
