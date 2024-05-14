<?php
include("./connection.php");
session_start();

// Check if user is logged in and session variables are set
if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
  $userName = $_SESSION['user_name'];
  $userId = $_SESSION['user_id'];
}

$action = $_POST['action'];
switch ($action) {
    case 'create':
        $user_id = $userId;
        $user_name = $userName;
        $patient_name = $_POST['patient_name'];
        $patient_age  = $_POST['patient_age'];
        $patient_gender = $_POST['patient_gender'];
        $mobile = $_POST['mobile'];
        $about = $_POST['about'];
        $department = $_POST['department'];
        $doctor_id = $_POST['doctor_id'];
        $doctor_name = $_POST['doctor_name'];
        $appointment_date = $_POST['appointment_date'];
        
        $sql = "INSERT INTO appointments (user_id, user_name, patient_name, age, gender, mobile, about, department, doctor_id, doctor_name, appointment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param('sssssssssss', $user_id, $user_name, $patient_name, $patient_age, $patient_gender, $mobile, $about, $department, $doctor_id, $doctor_name, $appointment_date);
        
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => true, 'id' => $stmt->insert_id]);
        } else {
            echo json_encode(['status' => false, 'error' => 'Error in creating appointment']);
        }
        break;

    case 'read':
        $user_id = $_POST['user_id'];
        
        $sql = "SELECT * FROM appointments WHERE user_id = ?";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param('s', $user_id);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        echo json_encode($items);
        break;
}

$conn->close();
?>
