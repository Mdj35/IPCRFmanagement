<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database configuration (XAMPP)
$host = 'localhost';
$dbname = 'laravel';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validation
    if (empty($data['lastname']) || empty($data['firstname']) || empty($data['employee_id']) || 
        empty($data['password']) || empty($data['role'])) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    if ($data['password'] !== $data['password_confirmation']) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit;
    }
    
    // Check if employee_id exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE employee_id = ?");
    $stmt->execute([$data['employee_id']]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Employee ID already exists']);
        exit;
    }
    
    // Hash password
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    
    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (lastname, firstname, employee_id, password, role, created_at) 
                          VALUES (?, ?, ?, ?, ?, NOW())");
    
    $stmt->execute([
        $data['lastname'],
        $data['firstname'],
        $data['employee_id'],
        $hashedPassword,
        $data['role']
    ]);
    
    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>