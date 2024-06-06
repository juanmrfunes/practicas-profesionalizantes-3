<?php
// api/delete_group.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$groupId = $data['groupId'];

if (!$groupId) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "DELETE FROM `group` WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $groupId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Group deleted']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
