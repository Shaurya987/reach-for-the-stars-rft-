<?php
// Database connection
$servername = "localhost"; // Change if necessary
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "final test";

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
$aadhar = $conn->real_escape_string($_POST['aadhar']);
$fathersName = $conn->real_escape_string($_POST['fathersName']);
$mothersName = $conn->real_escape_string($_POST['mothersName']);
$address = $conn->real_escape_string($_POST['address']);
$caste = $conn->real_escape_string($_POST['caste']);
$highestQualification = $conn->real_escape_string($_POST['highestQualification']);
$latestDegree = $conn->real_escape_string($_POST['latestDegree']);
$latestInstitution = $conn->real_escape_string($_POST['latestInstitution']);
$percentage10 = $conn->real_escape_string($_POST['percentage10']);
$percentage12 = $conn->real_escape_string($_POST['percentage12']);
$percentageCollege = $conn->real_escape_string($_POST['percentageCollege']);
$courses = $conn->real_escape_string($_POST['courses']);
$collegesApplied = $conn->real_escape_string($_POST['collegesApplied']);
$admissionStatus = $conn->real_escape_string($_POST['admissionStatus']);
$allIndiaExam = $conn->real_escape_string($_POST['allIndiaExam']);
$examName = $conn->real_escape_string($_POST['examName']);
$rankPercentile = $conn->real_escape_string($_POST['rankPercentile']);
$fathersOccupation = $conn->real_escape_string($_POST['fathersOccupation']);
$mothersOccupation = $conn->real_escape_string($_POST['mothersOccupation']);
$fathersIncome = $conn->real_escape_string($_POST['fathersIncome']);
$guardianName = $conn->real_escape_string($_POST['guardianName']);
$guardianOccupation = $conn->real_escape_string($_POST['guardianOccupation']);
$guardianIncome = $conn->real_escape_string($_POST['guardianIncome']);

// Handle file uploads
$aadharCard = $conn->real_escape_string(file_get_contents($_FILES['aadharCard']['tmp_name']));
$marksheet10 = $conn->real_escape_string(file_get_contents($_FILES['marksheet10']['tmp_name']));
$marksheet12 = $conn->real_escape_string(file_get_contents($_FILES['marksheet12']['tmp_name']));
$incomeCertificate = $conn->real_escape_string(file_get_contents($_FILES['incomeCertificate']['tmp_name']));

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
            '$rankPercentile', '$aadharCard', '$marksheet10', '$marksheet12', '$fathersOccupation', 
            '$mothersOccupation', '$fathersIncome', '$incomeCertificate', '$guardianName', 
            '$guardianOccupation', '$guardianIncome'
        )";

if ($conn->query($sql) === TRUE) {
    header("Location: success.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

