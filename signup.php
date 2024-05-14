<?php
// if($_SERVER["REQUEST_METHOD"] == "POST"){
// }
include 'connection.php';

$name = $_POST['name'];
$email = $_POST['email'];   
$password =$_POST['password'];

$hash_pw = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO auth(user_name,email,password,role) VALUES('$name','$email','$hash_pw','user')";
if ($conn->query($sql) === TRUE) {
    echo "Registered";
    header("location:index.php");
} else {
    echo "Error " . $sql . "<br>" . $conn->error;
}
