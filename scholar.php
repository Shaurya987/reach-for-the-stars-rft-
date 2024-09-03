<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentregistrationdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic Details
    $name = sanitize_input($_POST["name"]);
    $mobile = sanitize_input($_POST["mobile"]);
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);
    $confirmPassword = sanitize_input($_POST["confirmPassword"]);

    // Personal Details
    $fathersName = sanitize_input($_POST["fathersName"]);
    $mothersName = sanitize_input($_POST["mothersName"]);
    $address = sanitize_input($_POST["address"]);
    $caste = sanitize_input($_POST["caste"]);
    $highestQualification = sanitize_input($_POST["highestQualification"]);
    $latestDegree = sanitize_input($_POST["latestDegree"]);
    $latestInstitution = sanitize_input($_POST["latestInstitution"]);
    $percentage10 = sanitize_input($_POST["percentage10"]);
    $percentage12 = sanitize_input($_POST["percentage12"]);
    $percentageCollege = sanitize_input($_POST["percentageCollege"]);
    $courses = sanitize_input($_POST["courses"]);
    $collegesApplied = sanitize_input($_POST["collegesApplied"]);
    $admissionStatus = sanitize_input($_POST["admissionStatus"]);
    $allIndiaExam = sanitize_input($_POST["allIndiaExam"]);
    $examName = sanitize_input($_POST["examName"]);
    $rankPercentile = sanitize_input($_POST["rankPercentile"]);

    // Family and Income Details
    $fathersOccupation = sanitize_input($_POST["fathersOccupation"]);
    $mothersOccupation = sanitize_input($_POST["mothersOccupation"]);
    $annualIncome = sanitize_input($_POST["annualIncome"]);

    // Upload Documents and Course Details
    $collegeWebsite = sanitize_input($_POST["collegeWebsite"]);
    $courseName = sanitize_input($_POST["courseName"]);
    $feeStructure = $_FILES['feeStructure']['name'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["feeStructure"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check file type
    if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        echo "Sorry, only PDF, DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["feeStructure"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["feeStructure"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars(basename($_FILES["feeStructure"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO students (name, mobile, email, password, fathersName, mothersName, address, caste, highestQualification, latestDegree, latestInstitution, percentage10, percentage12, percentageCollege, courses, collegesApplied, admissionStatus, allIndiaExam, examName, rankPercentile, fathersOccupation, mothersOccupation, annualIncome, collegeWebsite, courseName, feeStructure)
            VALUES ('$name', '$mobile', '$email', '$password', '$fathersName', '$mothersName', '$address', '$caste', '$highestQualification', '$latestDegree', '$latestInstitution', '$percentage10', '$percentage12', '$percentageCollege', '$courses', '$collegesApplied', '$admissionStatus', '$allIndiaExam', '$examName', '$rankPercentile', '$fathersOccupation', '$mothersOccupation', '$annualIncome', '$collegeWebsite', '$courseName', '$feeStructure')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to success page
        header("Location: success.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="file"] {
            border: none;
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .submit-button, .next-button {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-button:hover, .next-button:hover {
            background-color: #218838;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 35px;
            cursor: pointer;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <form id="registrationForm" method="POST" enctype="multipart/form-data">
            <!-- Step 1: Basic Details -->
            <div class="step step-1 active">
                <h2>Step 1: Basic Details</h2>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="mobile">Mobile Number:</label>
                <input type="text" id="mobile" name="mobile" required>

                <label for="email">E-mail Address:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <i class="fa fa-eye toggle-password" onclick="togglePassword('password')"></i>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <i class="fa fa-eye toggle-password" onclick="togglePassword('confirmPassword')"></i>

                <button type="button" class="next-button" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 2: Personal Details -->
            <div class="step step-2">
                <h2>Step 2: Personal Details</h2>
                <label for="fathersName">Father’s Name:</label>
                <input type="text" id="fathersName" name="fathersName" required>

                <label for="mothersName">Mother’s Name:</label>
                <input type="text" id="mothersName" name="mothersName" required>

                <label for="address">Permanent Address:</label>
                <textarea id="address" name="address" rows="4" required></textarea>

                <label for="caste">Caste Category:</label>
                <select id="caste" name="caste" required>
                    <option value="">Select Caste</option>
                    <option value="General">General</option>
                    <option value="OBC">OBC</option>
                    <option value="SC">SC</option>
                    <option value="ST">ST</option>
                </select>

                <label for="highestQualification">Highest Qualification:</label>
                <select id="highestQualification" name="highestQualification" required>
                    <option value="">Select Qualification</option>
                    <option value="10th">10th</option>
                    <option value="12th">12th</option>
                    <option value="Undergraduate">Undergraduate</option>
                    <option value="Postgraduate">Postgraduate</option>
                </select>

                <label for="latestDegree">Latest Degree Obtained:</label>
                <input type="text" id="latestDegree" name="latestDegree" required>

                <label for="latestInstitution">Latest Institution Attended:</label>
                <input type="text" id="latestInstitution" name="latestInstitution" required>

                <label for="percentage10">Percentage in 10th Grade:</label>
                <input type="number" id="percentage10" name="percentage10" required>

                <label for="percentage12">Percentage in 12th Grade:</label>
                <input type="number" id="percentage12" name="percentage12" required>

                <label for="percentageCollege">Percentage in Latest Degree:</label>
                <input type="number" id="percentageCollege" name="percentageCollege" required>

                <label for="courses">Courses Interested In:</label>
                <select id="courses" name="courses" required>
                    <option value="">Select Course</option>
                    <option value="Medical">Medical</option>
                    <option value="Engineering">Engineering</option>
                </select>

                <label for="collegesApplied">Colleges Applied To:</label>
                <input type="text" id="collegesApplied" name="collegesApplied" required>

                <label for="admissionStatus">Admission Status:</label>
                <select id="admissionStatus" name="admissionStatus" required>
                    <option value="">Select Status</option>
                    <option value="Admitted">Admitted</option>
                    <option value="Not Admitted">Not Admitted</option>
                </select>

                <label for="allIndiaExam">All India Entrance Exam:</label>
                <select id="allIndiaExam" name="allIndiaExam" required>
                    <option value="">Select Exam</option>
                    <option value="JEE">JEE</option>
                    <option value="NEET">NEET</option>
                    <option value="CAT">CAT</option>
                    <option value="MAT">MAT</option>
                </select>

                <label for="examName">Name of the Exam:</label>
                <input type="text" id="examName" name="examName" required>

                <label for="rankPercentile">Rank/Percentile:</label>
                <input type="text" id="rankPercentile" name="rankPercentile" required>

                <button type="button" class="next-button" onclick="prevStep()">Previous</button>
                <button type="button" class="next-button" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 3: Family and Income Details -->
            <div class="step step-3">
                <h2>Step 3: Family and Income Details</h2>
                <label for="fathersOccupation">Father’s Occupation:</label>
                <input type="text" id="fathersOccupation" name="fathersOccupation" required>

                <label for="mothersOccupation">Mother’s Occupation:</label>
                <input type="text" id="mothersOccupation" name="mothersOccupation" required>

                <label for="annualIncome">Annual Family Income:</label>
                <input type="text" id="annualIncome" name="annualIncome" required>

                <button type="button" class="next-button" onclick="prevStep()">Previous</button>
                <button type="button" class="next-button" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 4: Upload Documents and Course Details -->
            <div class="step step-4">
                <h2>Step 4: Upload Documents and Course Details</h2>
                <label for="collegeWebsite">College Website:</label>
                <input type="url" id="collegeWebsite" name="collegeWebsite" required>

                <label for="courseName">Course Name:</label>
                <input type="text" id="courseName" name="courseName" required>

                <label for="feeStructure">Upload Fee Structure Document (PDF/DOC/DOCX):</label>
                <input type="file" id="feeStructure" name="feeStructure" required>

                <button type="button" class="next-button" onclick="prevStep()">Previous</button>
                <button type="submit" class="submit-button">Submit</button>
            </div>
        </form>
    </div>

    <script>
        let currentStep = 1;
        const steps = document.querySelectorAll('.step');

        function showStep(step) {
            steps.forEach((el, index) => {
                el.classList.toggle('active', index === step - 1);
            });
        }

        function nextStep() {
            if (validateStep(currentStep)) {
                currentStep++;
                if (currentStep > steps.length) {
                    currentStep = steps.length;
                }
                showStep(currentStep);
            }
        }

        function prevStep() {
            currentStep--;
            if (currentStep < 1) {
                currentStep = 1;
            }
            showStep(currentStep);
        }

        function validateStep(step) {
            const inputs = steps[step - 1].querySelectorAll('input, select, textarea');
            let valid = true;
            inputs.forEach(input => {
                if (input.required && !input.value) {
                    valid = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '';
                }
            });
            return valid;
        }

        function togglePassword(id) {
            const passwordField = document.getElementById(id);
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
        }
    </script>

</body>
</html>
