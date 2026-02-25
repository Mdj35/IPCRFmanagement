<?php
session_start();
header('Content-Type: application/json');

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
    
    $employee_id = $data['employee_id'] ?? '';
    $password = $data['password'] ?? '';
    
    // Validation
    if (empty($employee_id) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please enter both Employee ID and Password']);
        exit;
    }
    
    // Find user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE employee_id = ?");
    $stmt->execute([$employee_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Invalid Employee ID or Password']);
        exit;
    }
    
    // Verify password
    if (!password_verify($password, $user['password'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid Employee ID or Password']);
        exit;
    }
    
    // Store user data in session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['employee_id'] = $user['employee_id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['lastname'] = $user['lastname'];
    
    // Determine redirect URL based on role
    $redirectUrl = '/dashboard'; // Default redirect
    
    switch($user['role']) {
        case 'encoder':
            $redirectUrl = '/encoder';
            break;
        case 'admin':
            $redirectUrl = '/admin';
            break;
        case 'staff':
            $redirectUrl = '/home';
            break;
        case 'viewer':
            $redirectUrl = '/viewer';
            break;
    }
    
    echo json_encode([
        'success' => true, 
        'message' => 'Login successful!',
        'redirect' => $redirectUrl,
        'role' => $user['role']
    ]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>