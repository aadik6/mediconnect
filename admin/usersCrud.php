<?php
include("../connection.php");
$action = $_POST['action'];
switch($action){
    case 'read':
        $sql = "SELECT * FROM auth WHERE role = 'user'";
        $result = $conn->query(($sql));
        $items = [];
        while($row = $result->fetch_assoc()){
            $items[] = $row;
        }
        echo json_encode($items);
        break;

    case 'delete':
        $Uid = $_POST['Uid'];
        $sql = "DELETE FROM auth WHERE user_id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i',$Uid);
        $stmt->execute();
        echo json_encode(['status'=>true]);
        break;
        
    }
    $conn->close();
?>