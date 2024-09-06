<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Database connection
$servername = "sg2plmcpnl492025";
$username = "final_test_user";
$password = "P#Oy)75~CF}y";
$dbname = "final_test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize form data
$name = $conn->real_escape_string($_POST['name']);
$mobile = $conn->real_escape_string($_POST['mobile']);
$email = $conn->real_escape_string($_POST['email']);
$password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);

// Create a directory based on the sanitized email
$emailDir = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $email);
$uploadDir = __DIR__ . '/documents/' . $emailDir . '/';  // Define the upload directory

// Ensure the upload directory exists
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Error: Unable to create directory for uploads.");
    }
}

// Debugging to check the directory path
if (!is_dir($uploadDir)) {
    die("Error: Directory does not exist after creation attempt: " . $uploadDir);
} else {
    echo "Directory path: " . $uploadDir . "<br>";
}

// Prepare the file paths
$aadharCardPath = $uploadDir . basename($_FILES['aadharCard']['name']);
$marksheet10Path = $uploadDir . basename($_FILES['marksheet10']['name']);
$marksheet12Path = $uploadDir . basename($_FILES['marksheet12']['name']);
$incomeCertificatePath = $uploadDir . basename($_FILES['incomeCertificate']['name']);

// Debugging to check file paths
echo "Aadhar Card Path: " . $aadharCardPath . "<br>";
echo "Marksheet 10 Path: " . $marksheet10Path . "<br>";
echo "Marksheet 12 Path: " . $marksheet12Path . "<br>";
echo "Income Certificate Path: " . $incomeCertificatePath . "<br>";

// Move the uploaded files to the specified directory
if (move_uploaded_file($_FILES['aadharCard']['tmp_name'], $aadharCardPath) &&
    move_uploaded_file($_FILES['marksheet10']['tmp_name'], $marksheet10Path) &&
    move_uploaded_file($_FILES['marksheet12']['tmp_name'], $marksheet12Path) &&
    move_uploaded_file($_FILES['incomeCertificate']['tmp_name'], $incomeCertificatePath)) {

    // SQL query to insert data into the table
    $sql = "INSERT INTO student (
                name, mobile, email, password, aadhar, fathersName, mothersName, address, caste, 
                highestQualification, latestDegree, latestInstitution, 
                percentage10, percentage12, percentageCollege, courses, collegesApplied, 
                admissionStatus, allIndiaExam, examName, rankPercentile, aadharCard, marksheet10, 
                marksheet12, fathersOccupation, mothersOccupation, fathersIncome, incomeCertificate, 
                guardianName, guardianOccupation, guardianIncome
            ) 
            VALUES (
                '$name', '$mobile', '$email', '$password', '$aadhar', '$fathersName', '$mothersName', 
                '$address', '$caste','$highestQualification', '$latestDegree', 
                '$latestInstitution', '$percentage10', '$percentage12', '$percentageCollege', 
                '$courses', '$collegesApplied', '$admissionStatus', '$allIndiaExam', '$examName', 
                '$rankPercentile', '$aadharCardPath', '$marksheet10Path', '$marksheet12Path', '$fathersOccupation', 
                '$mothersOccupation', '$fathersIncome', '$incomeCertificatePath', '$guardianName', 
                '$guardianOccupation', '$guardianIncome'
            )";

    if ($conn->query($sql) === TRUE) {
        header("Location: success.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error uploading files. Check directory permissions and file paths.";
}

$conn->close();
?>
