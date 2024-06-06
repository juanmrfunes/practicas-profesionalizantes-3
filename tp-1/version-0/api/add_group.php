<?php
// api/add_group.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$groupName = $data['groupName'];

if (!$groupName) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "INSERT INTO `group` (name) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $groupName);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Group added']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
