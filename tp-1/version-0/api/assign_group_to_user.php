<?php
// api/assign_group_to_user.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];
$groupId = $data['groupId'];

if (!$userId || !$groupId) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "INSERT INTO user_group (user_id, group_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $groupId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Group assigned to user']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
