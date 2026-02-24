<?php
require_once '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get POST data
$name = trim($_POST['student_name'] ?? '');
$roll = trim($_POST['roll_number'] ?? '');
$dept = trim($_POST['department'] ?? '');
$category = trim($_POST['category'] ?? '');
$priority = trim($_POST['priority'] ?? '');
$date = trim($_POST['submission_date'] ?? date('Y-m-d'));
$desc = trim($_POST['description'] ?? '');

// Validate required fields
if (empty($name) || empty($roll) || empty($dept) || empty($category) || empty($priority) || empty($desc)) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

// Auto-generate ticket ID: find max number + 1
$result = $conn->query("SELECT ticket_id FROM tickets ORDER BY ticket_id DESC LIMIT 1");
$lastId = $result->fetch_assoc();
if ($lastId) {
    $num = intval(substr($lastId['ticket_id'], 4)) + 1;
} else {
    $num = 1;
}
$ticketId = 'TKT-' . str_pad($num, 3, '0', STR_PAD_LEFT);

// Insert ticket
$stmt = $conn->prepare("INSERT INTO tickets (ticket_id, student_name, roll_number, department, category, priority, description, status, submission_date) VALUES (?, ?, ?, ?, ?, ?, ?, 'Open', ?)");
$stmt->bind_param('ssssssss', $ticketId, $name, $roll, $dept, $category, $priority, $desc, $date);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'ticket_id' => $ticketId,
        'message' => "Ticket $ticketId created successfully"
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create ticket: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>