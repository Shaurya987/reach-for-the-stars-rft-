<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.html");
    exit();
}

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

// Get student ID from session
$student_id = $_SESSION['student_id'];

// Fetch user details from the database
$sql = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the student exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // If student not found, redirect to login
    header("Location: login.html");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .user-details {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #ddd;
            margin-right: 20px;
            border: 4px solid #4CAF50;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info {
            flex: 1;
            font-size: 18px;
        }

        .info p {
            margin: 8px 0;
            line-height: 1.6;
        }

        .info strong {
            font-weight: bold;
            color: #333;
        }

        .status-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
        }

        .status-section h3 {
            color: #4CAF50;
            font-size: 22px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .status-item {
            margin: 15px 0;
            font-size: 18px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: transform 0.3s;
        }

        .status-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .status-item strong {
            display: inline-block;
            width: 200px;
            font-weight: bold;
            color: #555;
        }

        .footer {
            margin-top: 40px;
            padding: 20px;
            background-color: #f1f1f1;
            border-top: 3px solid #4CAF50;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: justify;
            font-size: 16px;
            line-height: 1.8;
            color: #666;
        }

        .footer p {
            margin: 10px 0;
        }

        @media (max-width: 768px) {
            .user-details {
                flex-direction: column;
                align-items: center;
            }

            .profile-picture {
                margin-bottom: 15px;
            }

            .status-item strong {
                width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        Hi, <span id="name"><?php echo htmlspecialchars($user['name']); ?></span>!
    </div>
    <div class="container">
        <div class="user-details">
            <div class="profile-picture" id="profile-pic"></div>
            <div class="info">
                <p><strong>Phone No.:</strong> <span id="mobile"><?php echo htmlspecialchars($user['mobile']); ?></span></p>
                <p><strong>Email Address:</strong> <span id="email"><?php echo htmlspecialchars($user['email']); ?></span></p>
                <p><strong>Course:</strong> <span id="courses"><?php echo htmlspecialchars($user['courses']); ?></span></p>
                <p><strong>College:</strong> <span id="collegesApplied"><?php echo htmlspecialchars($user['collegesApplied']); ?></span></p>
            </div>
        </div>

        <div class="status-section">
            <h3>Scholarship Status</h3>
            <div class="status-item">
                <strong>Do You Need Mentorship?</strong> <span id="mentorship"><?php echo htmlspecialchars($user['mentorship_description']); ?></span>
            </div>
            <div class="status-item">
                <strong>Documents Uploaded:</strong> Aadhaar card, 10th Marksheet, 12th Marksheet, Father's Income Certificate
            </div>
            <div class="status-item">
                <strong>Amount Awarded:</strong> <span id="amount"><?php echo htmlspecialchars($user['amount']); ?></span>
            </div>
            <div class="status-item">
                <strong>Scholarship:</strong> <span id="scholarship-status"><?php echo htmlspecialchars($user['scholarship_status']); ?></span>
            </div>
        </div>

        <div class="footer">
            <p><strong>Note:</strong> If you have any questions regarding your scholarship status or need further assistance, please contact our support team at info@prayatnaworld.org. We are here to help you!</p>
        </div>
    </div>
</body>
</html>
