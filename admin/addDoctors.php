<!DOCTYPE html>
<html lang="en">

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

      // Collect form data for the doctors table
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
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $createdBy = $adminName;

      // Insert data into the auth table
      $sqlAuth = "INSERT INTO auth (user_name, email, password, role)
       VALUES (?, ?, ?, 'doctor')";
      $stmtAuth = $conn->prepare($sqlAuth);
      $stmtAuth->bind_param('sss', $name, $email, $password);
      $stmtAuth->execute();
      $userId = $stmtAuth->insert_id;

      // Insert data into the doctors table
      $sqlDoctors = "INSERT INTO doctors (user_id, name, department, qualification, experience, about, nmc, age, gender, email, mobile, image, createdBy)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmtDoctors = $conn->prepare($sqlDoctors);
      $stmtDoctors->bind_param('isssssissssss', $userId, $name, $department, $qualification, $experience, $about, $nmcNumber, $age, $gender, $email, $mobile, $uploadPath, $createdBy);
      $stmtDoctors->execute();
      if ($stmtDoctors->affected_rows > 0) {
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

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Admin-Dashboard</title>
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.html">MediConnect</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <!-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" /> -->
        <!-- <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> -->
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!"><?php echo $adminName; ?></a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="index.html">
              <div class="sb-nav-link-icon">
                <i class="fas fa-tachometer-alt"></i>
              </div>
              Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Interface</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon">
                <i class="fa-solid fa-user-doctor"></i>
              </div>
              Doctor
              <div class="sb-sidenav-collapse-arrow">
                <i class="fas fa-angle-down"></i>
              </div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="./allDoctors.php">All Doctors</a>
                <a class="nav-link" href="./addDoctors.php">Add Doctors</a>
              </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts_2" aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon">
                <i class="fa-regular fa-calendar-check"></i>
              </div>
              Appointments
              <div class="sb-sidenav-collapse-arrow">
                <i class="fas fa-angle-down"></i>
              </div>
            </a>
            <div class="collapse" id="collapseLayouts_2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="./allAppointment.php">All Appointments</a>
                <a class="nav-link" href="./successAppointment.php">Success</a>
                <a class="nav-link" href="./pendingAppointment.php">Pending</a>
              </nav>
            </div>

            <a class="nav-link" href="./department.php">
              <div class="sb-nav-link-icon">
                <i class="fas fa-chart-area"></i>
              </div>
              Departments
            </a>
            <a class="nav-link" href="./users.php">
              <div class="sb-nav-link-icon">
                <i class="fa-solid fa-users"></i>
              </div>
              Users
            </a>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          <?php echo $adminName; ?> [Admin]
        </div>
      </nav>
    </div>

    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Add Doctor</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Add Doctor</li>
          </ol>

          <!-- Add Doctor Form -->
          <div class="card mb-4">
            <div class="card-body">
              <form id="addDoctorForm" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                  <label for="department" class="form-label">Department</label>
                  <select class="form-control" id="department" name="department" required>
                    <option value="">Select Department</option>
                    <?php
                    include("../connection.php");
                    // Fetch data from the department table using the connection from 'connection.php'
                    $sql = "SELECT * FROM departments";
                    $result = mysqli_query($conn, $sql);

                    // Loop through the results and populate the dropdown options
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row['dep_name'] . "'>" . $row['dep_name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="qualification" class="form-label">Qualification</label>
                  <input type="text" class="form-control" id="qualification" name="qualification" required>
                </div>
                <div class="mb-3">
                  <label for="experience" class="form-label">Experience</label>
                  <input type="number" class="form-control" id="experience" name="experience" required>
                </div>
                <div class="mb-3">
                  <label for="about" class="form-label">About</label>
                  <textarea class="form-control" id="about" name="about" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="nmcNumber" class="form-label">NMC Number</label>
                  <input type="number" class="form-control" id="nmcNumber" name="nmcNumber" required>
                </div>
                <div class="mb-3">
                  <label for="age" class="form-label">Age</label>
                  <input type="number" class="form-control" id="age" name="age" required>
                </div>
                <div class="mb-3">
                  <label for="gender" class="form-label">Gender</label>
                  <select class="form-select" id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                  <label for="mobile" class="form-label">Mobile</label>
                  <input type="tel" class="form-control" id="mobile" name="mobile" required>
                </div>
                <div class="mb-3">
                  <label for="image" class="form-label">Image</label>
                  <input type="file" class="form-control" id="image" name="image" required>
                </div>
                <div class="mb-3">
                  <label for="createdBy" class="form-label">Created By</label>
                  <input type="text" class="form-control" id="createdBy" name="createdBy" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
          <!-- End Add Doctor Form -->

        </div>
      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; MediConnect 2024</div>
            <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
</body>

</html>