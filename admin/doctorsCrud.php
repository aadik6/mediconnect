<?php
include("../connection.php");

$action = isset($_POST['action']) ? $_POST['action'] : null;

switch ($action) {
    case 'create':
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];  // Use the file name or any suitable identifier
            $imagePath = 'uploads/' . $image;  // Set the upload path
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                // File uploaded successfully
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
                $createdBy = $_POST['createdBy'];

                // Insert doctor details into database
                $sql = "INSERT INTO doctors (name, department, qualification, experience, about, NMc_number, age, gender, email, mobile, image, loginId, password, createdBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssssisssssss', $name, $department, $qualification, $experience, $about, $nmcNumber, $age, $gender, $email, $mobile, $imagePath, $loginId, $password, $createdBy);
                $stmt->execute();
                echo json_encode(['status' => true, 'id' => $stmt->insert_id]);
            } else {
                echo json_encode(['status' => false, 'message' => 'Failed to upload image.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Please select an image file.']);
        }
        break;

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
        $sql = "DELETE FROM doctors WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo json_encode(['status' => true]);
        break;
}

$conn->close();
?>
