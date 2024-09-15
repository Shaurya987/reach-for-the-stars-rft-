<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Database connection details
$servername = "confidential";
$username = "confidential";
$password = "confidential";
$dbname = "confidential";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the query
    $sql = "SELECT * FROM student WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the student exists
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $student['password'])) {
            // Password is correct, set session and redirect to dashboard
            $_SESSION['student_id'] = $student['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect
            header("Location: error.html");
            exit();
        }
    } else {
        // Student does not exist
        header("Location: error.html");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
