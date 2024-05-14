<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header text-center">Sign Up</h5>
                    <div class="card-body">
                        <form action="" method="post" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required minlength="6">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                            <a href="./login.php">Already have a/c</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var email = document.getElementById("email").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            if (password.length < 6) {
                alert("Password should be at least 6 characters long.");
                return false;
            }

            // Validate email format using regular expression
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true; // Form will submit if all validations pass
        }
    </script>
</body>

</html>

<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hash_pw = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO auth(user_name,email,password,role) VALUES('$name','$email','$hash_pw','user')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registered');</script>";
        header("location:index.php");
    } else {
        echo "Error " . $sql . "<br>" . $conn->error;
    }
}
?>
