<?php
require_once '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$ticketId = trim($_POST['ticket_id'] ?? '');
$newStatus = trim($_POST['status'] ?? '');

if (empty($ticketId) || empty($newStatus)) {
    http_response_code(400);
    echo json_encode(['error' => 'ticket_id and status are required']);
    exit;
}

// Validate status
$validStatuses = ['Open', 'In-Progress', 'Resolved', 'Verified'];
if (!in_array($newStatus, $validStatuses)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid status. Must be: Open, In-Progress, Resolved, or Verified']);
    exit;
}

// Set resolved_date when status changes to Resolved
$resolvedDate = null;
if ($newStatus === 'Resolved') {
    $resolvedDate = date('Y-m-d');
    $stmt = $conn->prepare("UPDATE tickets SET status = ?, resolved_date = ? WHERE ticket_id = ?");
    $stmt->bind_param('sss', $newStatus, $resolvedDate, $ticketId);
} else {
    $stmt = $conn->prepare("UPDATE tickets SET status = ? WHERE ticket_id = ?");
    $stmt->bind_param('ss', $newStatus, $ticketId);
}

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => "Ticket $ticketId updated to $newStatus"]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => "Ticket $ticketId not found"]);
    }
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update ticket']);
}

$stmt->close();
$conn->close();
?>