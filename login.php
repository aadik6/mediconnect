<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('connection.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM auth WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['role'] = $row['role'];
            // echo "logged in";
            // echo $_SESSION['role'];
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin");
            } elseif($_SESSION['role'] =='doctor'){
                header("Location: doctors");
            }
            else {

                header("Location: user");
            }
            // exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}
?>

<!-- html code -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #9A616D;">
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bWVkaWNhbHxlbnwwfDF8MHx8fDA%3D" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action="login.php" method="post">

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <!-- <span class="h1 fw-bold mb-0">Logo</span> -->
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="email" id="email" name="email" class="form-control form-control-lg" />
                                            <label class="form-label" for="email">Email address</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                            <label class="form-label" for="password">Password</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="">Login</button>
                                        </div>

                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="./signup.php" style="color: #393f81;">Register here</a></p>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>