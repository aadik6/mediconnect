<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    echo "You are not logged in!";
    // Redirect to login page or handle accordingly
    exit(); // Stop further execution of the script
}

$adminName = $_SESSION['user_name'];

// Database connection
include("../connection.php"); // Adjust the path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted with an image file
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Define upload directory
        $uploadDir = "uploads/";
        // Ensure this directory exists and is writable

        // Generate a unique file name to prevent overwriting existing files
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $uploadPath = $uploadDir . $fileName;

        // Move the file to the specified directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            echo "Image uploaded successfully.<br>";

            // Collect other form data
            $name = $_POST['name'];
            $department = $_POST['department'];
            $qualification = $_POST['qualification'];
            $experience = $_POST['experience'];
            $about = $_POST['about'];
            $nmcNumber = $_POST['nmcNumber'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $loginId = $_POST['loginId'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $createdBy = $adminName;

            // SQL to insert data into the database
            $sql = "INSERT INTO doctors (name, department, qualification, experience, about, nmc, age, gender, email, mobile, image, login_id, password, createdBy)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssssisssssss', $name, $department, $qualification, $experience, $about, $nmcNumber, $age, $gender, $email, $mobile, $uploadPath, $loginId, $password, $createdBy);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "Doctor added successfully.";
            } else {
                echo "Failed to add doctor.";
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Please select an image file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <h1>Add a New Doctor</h1>
    <form method="post" enctype="multipart/form-data">
        Name: <input type="text" name="name" required><br>
        Department: <input type="text" name="department" required><br>
        Qualification: <input type="text" name="qualification" required><br>
        Experience: <input type="number" name="experience" required><br>
        About: <textarea name="about" required></textarea><br>
        NMC Number: <input type="text" name="nmcNumber" required><br>
        Age: <input type="number" name="age" required><br>
        Gender: <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br>
        Email: <input type="email" name="email" required><br>
        Mobile: <input type="tel" name="mobile" required><br>
        Image: <input type="file" name="image" required><br>
        Login ID: <input type="text" name="loginId" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
