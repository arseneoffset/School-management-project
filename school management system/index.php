
<?php
// Database connection settings
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";      // Replace with your database password
$dbname = "mydatabase";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize form inputs
$name = trim($_POST['name']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Basic validation
if (empty($name) || empty($password) || empty($confirmPassword)) {
    echo "Please fill in all fields.";
    exit();
}

if (strlen($password) < 6) {
    echo "Password must be at least 6 characters long.";
    exit();
}

if ($password !== $confirmPassword) {
    echo "Passwords do not match.";
    exit();
}

// Hash the password before storing
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $hashedPassword);

// Execute the statement
if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
