<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Check if user is logged in and session variables are set
if (isset($_SESSION['user_name'])) {
  $createdBy = $_SESSION['user_name'];
} else {
  // Default value or handle the case when user is not logged in
  $createdBy = "Unknown";
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
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!"><?php echo $createdBy; ?></a></li>
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
          <?php echo $createdBy; ?> [Admin]
        </div>
      </nav>
    </div>

    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Departments</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Departments</li>
          </ol>

          <div class="card mb-4">
            <div class="card-header">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add department
              </button>

              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Add Department</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Name: <input class="form-control" type="text" id="dep_name" value="">
                      CreatedBy: <input class="form-control" type="text" id="createdBy" value="<?php echo $createdBy; ?>" readonly>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Update Department Modal -->
              <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="updateModalLabel">Update Department</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" id="update_dep_id">
                      <div class="mb-3">
                        <label for="update_dep_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="update_dep_name">
                      </div>
                      <div class="mb-3">
                        <label for="update_createdBy" class="form-label">Created By</label>
                        <input type="text" class="form-control" id="update_createdBy" value="<?php echo $createdBy; ?>" readonly>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="updateChangesBtn">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>


            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>CreatedBy</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="department_record">
                    <?php
                    include("../connection.php");
                    $sql = "SELECT * FROM departments";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['dep_id'] . "</td>";
                        echo "<td>" . $row['dep_name'] . "</td>";
                        echo "<td>" . $row['createdBy'] . "</td>";
                        echo "<td>
                            <a href='' class='btn btn-primary update-btn' data-dep-id='" . $row['dep_id'] . "' data-dep-name='" . $row['dep_name'] . "' data-bs-toggle='modal' data-bs-target='#updateModal'>Update</a>
                            <button onclick='deleteDepartment(" . $row['dep_id'] . ")' class='btn btn-danger'>Delete</button>
                        </td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr><td colspan='3'>No departments found</td></tr>";
                    }
                    mysqli_close($conn);
                    ?>
                  </tbody>
                </table>
            </div>
          </div>

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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#saveChangesBtn').on("click", function() {
      createDepartments();
    });




    function createDepartments() {
      var name = $('#dep_name').val();
      var createdBy = $('#createdBy').val();
      $.ajax({
        type: 'POST',
        url: 'crud.php',
        data: {
          action: 'create',
          name: name,
          createdBy: createdBy
        },
        success: function(response) {
          $('#exampleModal').modal('hide');
          fetchDepartments();
        }
      });
    }

    function fetchDepartments() {
      $.ajax({
        type: "POST",
        url: "crud.php",
        data: {
          action: 'read'
        },
        success: function(response) {
          var items = JSON.parse(response);
          console.log(items)
          var itemList = $('#department_record');
          itemList.empty();
          if (items.length > 0) {
            items.forEach(function(item) {
              itemList.append('<tr>' +
                '<td>' + item.dep_id + '</td>' +
                '<td>' + item.dep_name + '</td>' +
                '<td>' + item.createdBy + '</td>' +
                '<td>' +
                '<a href="update_department.php?id=' + item.id + '"><button class="btn btn-primary">Update</button></a>' +
                '<a href="delete_department.php?id=' + item.id + '"><button class="btn btn-danger">Delete</button></a>' +
                '</td>' +
                '</tr>');
            });
          } else {
            itemList.append('<tr><td colspan="4">No departments found</td></tr>');
          }
        }
      });
    }

    function deleteDepartment(depId) {
      console.log(depId)
      if (confirm("Are you sure you want to delete this department?")) {
        $.ajax({
          type: 'POST',
          url: 'crud.php',
          data: {
            action: 'delete',
            depId: depId
          },
          success: function(response) {
            fetchDepartments();
          }
        });
      }
    }

    // Update button click event
    $('.update-btn').on("click", function() {
      var depId = $(this).data('dep-id');
      var depName = $(this).data('dep-name');
      $('#update_dep_id').val(depId);
      $('#update_dep_name').val(depName);
    });

    // Save changes button click event for updating department
    $('#updateChangesBtn').on("click", function() {
      updateDepartment();
    });

    // Function to update department
    function updateDepartment() {
      var id = $('#update_dep_id').val();
      var name = $('#update_dep_name').val();
      console.log(name)
      var createdBy = $('#update_createdBy').val(); // You might want to remove this line if createdBy is not editable
      $.ajax({
        type: 'POST',
        url: 'crud.php',
        data: {
          action: 'update',
          id: id,
          name: name
        },
        success: function(response) {
          $('#updateModal').modal('hide');
          fetchDepartments();
        }
      });
    }
  </script>


</body>

</html>