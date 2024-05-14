<?php
include("../connection.php");

$action = $_POST['action'];

switch ($action) {
    case 'read':
        $sql = "SELECT * FROM doctors";
        $result = $conn->query($sql);
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        echo json_encode($items);
        break;

    case 'update':
        $id = $_POST['id'];
        $name = $_POST['name'];
        $department = $_POST['department'];
        $qualification = $_POST['qualification'];
        $experience = $_POST['experience'];
        $about = $_POST['about'];
        $nmcNumber = $_POST['NMc_number'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $loginId = $_POST['loginId'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "UPDATE doctors SET name=?, department=?, qualification=?, experience=?, about=?, NMc_number=?, age=?, gender=?, email=?, mobile=?, loginId=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssisssssi', $name, $department, $qualification, $experience, $about, $nmcNumber, $age, $gender, $email, $mobile, $loginId, $password, $id);
        $stmt->execute();
        echo json_encode(['status' => true]);
        break;

    case 'delete':
        $id = $_POST['id'];
        $sql = "DELETE FROM doctors WHERE doctor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo json_encode(['status' => true]);
        break;
}

$conn->close();
