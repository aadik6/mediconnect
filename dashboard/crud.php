<?php
include("../connection.php");

$action = $_POST['action'];
switch ($action) {
    case 'create':
        $name = $_POST['name'];
        $createdBy = $_POST['createdBy'];
        $sql = "INSERT INTO departments (dep_name, createdBy) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $name, $createdBy);
        $stmt->execute();
        echo json_encode(['status' => true, 'id' => $stmt->insert_id]);
        break;

    case 'read':
        $sql = "SELECT * FROM departments";
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
        // $createdBy = $_POST['createdBy'];
        $sql = "UPDATE departments SET dep_name = ? WHERE dep_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        echo json_encode(['status' => true]);
        break;

    case 'delete':
        $id = $_POST['depId'];
        $sql = "DELETE FROM departments WHERE dep_id = (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo json_encode(['status' => true]);
        break;

        $conn->close();
}
