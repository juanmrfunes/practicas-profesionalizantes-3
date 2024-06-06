<?php
// api/assign_action_to_group.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$groupId = $data['groupIdAction'];
$actionId = $data['actionId'];

if (!$groupId || !$actionId) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "INSERT INTO group_action (group_id, action_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $groupId, $actionId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Action assigned to group']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
