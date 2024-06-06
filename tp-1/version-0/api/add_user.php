<?php
// api/add_user.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

if (!$username || !$password) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "INSERT INTO user (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo json_encode(['message' => 'User added']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
