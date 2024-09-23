<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Database connection
$servername = "confidential";
$username = "confidential";
$password = "confidential";
$dbname = "confidential";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize form data with isset checks
$name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
$mobile = isset($_POST['mobile']) ? $conn->real_escape_string($_POST['mobile']) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$password = isset($_POST['password']) ? password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT) : '';

$aadhar = isset($_POST['aadhar']) ? $conn->real_escape_string($_POST['aadhar']) : '';
$fathersName = isset($_POST['fathersName']) ? $conn->real_escape_string($_POST['fathersName']) : '';
$mothersName = isset($_POST['mothersName']) ? $conn->real_escape_string($_POST['mothersName']) : '';
$address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';
$caste = isset($_POST['caste']) ? $conn->real_escape_string($_POST['caste']) : '';
$highestQualification = isset($_POST['highestQualification']) ? $conn->real_escape_string($_POST['highestQualification']) : '';
$latestDegree = isset($_POST['latestDegree']) ? $conn->real_escape_string($_POST['latestDegree']) : '';
$latestInstitution = isset($_POST['latestInstitution']) ? $conn->real_escape_string($_POST['latestInstitution']) : '';
$percentage10 = isset($_POST['percentage10']) ? $conn->real_escape_string($_POST['percentage10']) : '';
$percentage12 = isset($_POST['percentage12']) ? $conn->real_escape_string($_POST['percentage12']) : '';
$percentageCollege = isset($_POST['percentageCollege']) ? $conn->real_escape_string($_POST['percentageCollege']) : '';
$courses = isset($_POST['courses']) ? $conn->real_escape_string($_POST['courses']) : '';
$collegesApplied = isset($_POST['collegesApplied']) ? $conn->real_escape_string($_POST['collegesApplied']) : '';
$admissionStatus = isset($_POST['admissionStatus']) ? $conn->real_escape_string($_POST['admissionStatus']) : '';
$allIndiaExam = isset($_POST['allIndiaExam']) ? $conn->real_escape_string($_POST['allIndiaExam']) : '';
$examName = isset($_POST['examName']) ? $conn->real_escape_string($_POST['examName']) : '';
$rankPercentile = isset($_POST['rankPercentile']) ? $conn->real_escape_string($_POST['rankPercentile']) : '';
$fathersOccupation = isset($_POST['fathersOccupation']) ? $conn->real_escape_string($_POST['fathersOccupation']) : '';
$mothersOccupation = isset($_POST['mothersOccupation']) ? $conn->real_escape_string($_POST['mothersOccupation']) : '';
$fathersIncome = isset($_POST['fathersIncome']) ? $conn->real_escape_string($_POST['fathersIncome']) : '';
$guardianName = isset($_POST['guardianName']) ? $conn->real_escape_string($_POST['guardianName']) : '';
$guardianOccupation = isset($_POST['guardianOccupation']) ? $conn->real_escape_string($_POST['guardianOccupation']) : '';
$guardianIncome = isset($_POST['guardianIncome']) ? $conn->real_escape_string($_POST['guardianIncome']) : '';

// Retrieve the mentorship-related form data with isset checks
$mentorshipNeeded = isset($_POST['mentorship_Needed']) ? $conn->real_escape_string($_POST['mentorship_Needed']) : '';
$mentorshipDescription = isset($_POST['mentorship_Description']) ? $conn->real_escape_string($_POST['mentorship_Description']) : '';

// Create a directory based on the sanitized email
$emailDir = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $email);
$uploadDir = __DIR__ . '/documents/' . $emailDir . '/';  // Define the upload directory

// Ensure the upload directory exists
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Error: Unable to create directory for uploads.");
    }
}

// Initialize file paths
$aadharCardPath = '';
$marksheet10Path = '';
$marksheet12Path = '';
$incomeCertificatePath = '';
$feeStructurePath = '';
$admissionSlipPath = '';
$latestDegreeDocPath = ''; // New field for the latest degree document

// Move the uploaded files to the specified directory and handle errors
if (isset($_FILES['aadharCard']) && $_FILES['aadharCard']['error'] === UPLOAD_ERR_OK) {
    $aadharCardPath = $uploadDir . basename($_FILES['aadharCard']['name']);
    if (!move_uploaded_file($_FILES['aadharCard']['tmp_name'], $aadharCardPath)) {
        die("Error uploading Aadhar Card.");
    }
}

if (isset($_FILES['marksheet10']) && $_FILES['marksheet10']['error'] === UPLOAD_ERR_OK) {
    $marksheet10Path = $uploadDir . basename($_FILES['marksheet10']['name']);
    if (!move_uploaded_file($_FILES['marksheet10']['tmp_name'], $marksheet10Path)) {
        die("Error uploading Marksheet 10.");
    }
}

if (isset($_FILES['marksheet12']) && $_FILES['marksheet12']['error'] === UPLOAD_ERR_OK) {
    $marksheet12Path = $uploadDir . basename($_FILES['marksheet12']['name']);
    if (!move_uploaded_file($_FILES['marksheet12']['tmp_name'], $marksheet12Path)) {
        die("Error uploading Marksheet 12.");
    }
}

if (isset($_FILES['incomeCertificate']) && $_FILES['incomeCertificate']['error'] === UPLOAD_ERR_OK) {
    $incomeCertificatePath = $uploadDir . basename($_FILES['incomeCertificate']['name']);
    if (!move_uploaded_file($_FILES['incomeCertificate']['tmp_name'], $incomeCertificatePath)) {
        die("Error uploading Income Certificate.");
    }
}

if (isset($_FILES['feeStructure']) && $_FILES['feeStructure']['error'] === UPLOAD_ERR_OK) {
    $feeStructurePath = $uploadDir . basename($_FILES['feeStructure']['name']);
    if (!move_uploaded_file($_FILES['feeStructure']['tmp_name'], $feeStructurePath)) {
        die("Error uploading Fee Structure.");
    }
}

if (isset($_FILES['admissionSlip']) && $_FILES['admissionSlip']['error'] === UPLOAD_ERR_OK) {
    $admissionSlipPath = $uploadDir . basename($_FILES['admissionSlip']['name']);
    if (!move_uploaded_file($_FILES['admissionSlip']['tmp_name'], $admissionSlipPath)) {
        die("Error uploading Admission Slip.");
    }
}

if (isset($_FILES['latestDegreeDoc']) && $_FILES['latestDegreeDoc']['error'] === UPLOAD_ERR_OK) {
    $latestDegreeDocPath = $uploadDir . basename($_FILES['latestDegreeDoc']['name']);
    if (!move_uploaded_file($_FILES['latestDegreeDoc']['tmp_name'], $latestDegreeDocPath)) {
        die("Error uploading Latest Degree Document.");
    }
}

// SQL query to insert data into the table
$sql = "INSERT INTO student (
            name, mobile, email, password, aadhar, fathersName, mothersName, address, caste, 
            highestQualification, latestDegree, latestInstitution, 
            percentage10, percentage12, percentageCollege, courses, collegesApplied, 
            admissionStatus, allIndiaExam, examName, rankPercentile, aadharCard, marksheet10, 
            marksheet12, fathersOccupation, mothersOccupation, fathersIncome, incomeCertificate, 
            guardianName, guardianOccupation, guardianIncome, fee_structure, admission_slip, 
            mentorship_needed, mentorship_description, latest_degree_document
        ) 
        VALUES (
            '$name', '$mobile', '$email', '$password', '$aadhar', '$fathersName', '$mothersName', 
            '$address', '$caste', '$highestQualification', '$latestDegree', 
            '$latestInstitution', '$percentage10', '$percentage12', '$percentageCollege', 
            '$courses', '$collegesApplied', '$admissionStatus', '$allIndiaExam', '$examName', 
            '$rankPercentile', '$aadharCardPath', '$marksheet10Path', '$marksheet12Path', '$fathersOccupation', 
            '$mothersOccupation', '$fathersIncome', '$incomeCertificatePath', '$guardianName', 
            '$guardianOccupation', '$guardianIncome', '$feeStructurePath', '$admissionSlipPath', 
            '$mentorshipNeeded', '$mentorshipDescription', '$latestDegreeDocPath'
        )";

if ($conn->query($sql) === TRUE) {
    // Redirect to success page after successful insertion
    header("Location: success-student.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
