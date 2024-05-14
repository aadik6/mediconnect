<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Check if user is logged in and session variables are set
if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];
} else {
    // Default value or handle the case when user is not logged in
    $userName = "Unknown";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">MediConnect</a>
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
                    <li><a class="dropdown-item" href="#!"><?php echo $userName; ?></a></li>
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
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="./doctors.php">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            Doctors
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $userName; ?> [user]
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Doctors</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Doctors</li>
                    </ol>

                    <!-- Add Doctor Form -->
                    <div class="card mb-4">
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            <!-- Book appointment to Dr -->
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Doctor Name</label>
                                                <input type="text" class="form-control" id="recipient-name" readonly />
                                            </div>
                                            <div class="mb-3">
                                                <label for="deases-name" class="col-form-label">Deases Category</label>
                                                <input type="text" class="form-control" id="deases-name" readonly />
                                            </div>
                                            <div class="mb-3">

                                                <label for="patient_name" class="col-form-label">Name:</label>
                                                <input type="text" class="form-control" id="patient_name">
                                                <label for="patient_age" class="col-form-label">Age:</label>
                                                <input type="number" class="form-control" id="patient_age">
                                                <label for="patient_gender" class="col-form-label">Gender</label>
                                                <select name="patient_gender" class="form-control" id="patient_gender">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <label for="patient_mobile" class="col-form-label">Mobile No:</label>
                                                <input type="tel" class="form-control" id="patient_mobile">
                                                <label for="appointment_date" class="col-form-label">Visit date:</label>
                                                <input type="date" class="form-control" id="appointment_date">
                                                <label for="about" class="col-form-label">Describe problem:</label>
                                                <textarea class="form-control" id="about"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button" class="btn btn-primary" id="createAppointment">
                                            Send message
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- doctors details modal -->
                        <div class="modal fade" id="doctorDetailsModal" tabindex="-1" aria-labelledby="doctorDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="doctorDetailsModalLabel">Doctor Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Display doctor details dynamically here -->
                                        <h4 id="doctorName"></h4>
                                        <p id="doctorAbout"></p>
                                        <ul id="doctorInfo" class="list-group list-group-flush">
                                            <li class="list-group-item" id="doctorDepartment"></li>
                                            <li class="list-group-item" id="doctorNMC"></li>
                                            <li class="list-group-item" id="doctorExperience"></li>
                                            <li class="list-group-item" id="qualification"></li>
                                            <li class="list-group-item" id="age"></li>
                                            <li class="list-group-item" id="mobile"></li>
                                            <li class="list-group-item" id="gender"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <section id="doctors_list" class="overflow-hidden">
                            <div class="row row-cols-2 row-cols-md-3 g-5">
                                <?php
                                include("../connection.php");
                                // Query to fetch doctor details
                                $sql = "SELECT * FROM doctors";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <div class="col">
                                            <div class="card">
                                                <img src="../admin/<?php echo $row['image']; ?>" class="card-img-top" alt="Doctor Image">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                                    <p class="card-text"><?php echo $row['about']; ?></p>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">Department: <?php echo $row['department']; ?></li>
                                                    <li class="list-group-item">NMC: <?php echo $row['nmc']; ?></li>
                                                    <li class="list-group-item">Experience: <?php echo $row['experience']; ?> Years</li>
                                                    <!-- <li class="list-group-item">id: <?php echo $row['doctor_id']; ?></li> -->
                                                </ul>
                                                <div class="card-body">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo $row['name']; ?>" data-bs-category="<?php echo $row['department']; ?>" data-bs-id="<?php echo $row['doctor_id']; ?>">
                                                        Appointment
                                                    </button>
                                                    <button type="button" class="btn btn-primary" onclick="showDoctorDetails('<?php echo $row['name']; ?>', '<?php echo $row['about']; ?>', '<?php echo $row['department']; ?>', '<?php echo $row['nmc']; ?>', '<?php echo $row['experience']; ?>', '<?php echo $row['qualification']; ?>', '<?php echo $row['age']; ?>', '<?php echo $row['mobile']; ?>', '<?php echo $row['gender']; ?>')">Details</button>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "0 results";
                                }
                                ?>
                            </div>
                        </section>

                        <!-- doctors details modal -->
                        <script>
                            function showDoctorDetails(name, about, department, nmc, experience, qualification, age, mobile, gender) {
                                // Populate the modal with doctor details
                                document.getElementById('doctorDetailsModalLabel').innerText = name;
                                document.getElementById('doctorAbout').innerText = about;
                                document.getElementById('doctorDepartment').innerText = 'Department: ' + department;
                                document.getElementById('doctorNMC').innerText = 'NMC: ' + nmc;
                                document.getElementById('doctorExperience').innerText = 'Experience: ' + experience + ' Years';
                                document.getElementById('qualification').innerText = 'Education: ' + qualification;
                                document.getElementById('age').innerText = 'Age: ' + age + ' Years';
                                document.getElementById('mobile').innerText = 'Phone: ' + mobile;
                                document.getElementById('gender').innerText = 'Gender: ' + gender;

                                // Show the modal
                                var doctorDetailsModal = new bootstrap.Modal(document.getElementById('doctorDetailsModal'));
                                doctorDetailsModal.show();
                            }
                        </script>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <script>
                            const exampleModal = document.getElementById("exampleModal");
                            var doctorId;
                            if (exampleModal) {
                                exampleModal.addEventListener("show.bs.modal", (event) => {
                                    // Button that triggered the modal
                                    const button = event.relatedTarget;
                                    // Extract info from data-bs-* attributes
                                    const recipient = button.getAttribute("data-bs-whatever");
                                    const category = button.getAttribute("data-bs-category");
                                    const drId = button.getAttribute("data-bs-id");
                                    doctorId = drId

                                    // Update the modal's content.
                                    const modalTitle = exampleModal.querySelector(".modal-title");
                                    const modalBodyInput = exampleModal.querySelector(
                                        ".modal-body #recipient-name"
                                    );
                                    const modalBodyDeases = exampleModal.querySelector(
                                        ".modal-body #deases-name"
                                    );

                                    modalBodyDeases.value = category;
                                    modalTitle.textContent = `Book appointment to Dr. ${recipient}`;
                                    modalBodyInput.value = recipient;
                                });

                                $('#createAppointment').on("click", function() {
                                    createAppointment(doctorId)
                                })

                                function createAppointment(drId) {
                                    var patient_name = $('#patient_name').val();
                                    var age = $('#patient_age').val();
                                    var gender = $('#patient_gender').val();
                                    var mobile = $('#patient_mobile').val();
                                    var about = $('#about').val();
                                    var doctor_name = $('#recipient-name').val();
                                    var department = $('#deases-name').val();
                                    var date = $('#appointment_date').val();
                                    var doctor_id = drId
                                    $.ajax({
                                        type: 'Post',
                                        url: 'CRappointment.php',
                                        data: {
                                            action: 'create',
                                            patient_name: patient_name,
                                            patient_age: age,
                                            patient_gender: gender,
                                            mobile: mobile,
                                            about: about,
                                            department: department,
                                            doctor_id: doctor_id,
                                            doctor_name: doctor_name,
                                            appointment_date: date
                                        },
                                        success: function(response) {
                                            $('#exampleModal').modal('hide');
                                        }
                                    })
                                }
                            }
                        </script>

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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>