<?php
include("../connection.php");

$action = $_POST['action'];
switch ($action) {
    case 'read':
        $sql = "SELECT * FROM appointments";
        $result = $conn->query($sql);
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        echo json_encode($items);
        break;

    case 'update':
        $id = $_POST['id'];
        $sql = "UPDATE appointments SET status = 'success' WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(['status' => true]);
        break;
        $conn->close();
    }
    $conn->close();
