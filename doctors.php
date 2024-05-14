<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Doctors</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
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
              <label for="message-text" class="col-form-label">Message:</label>
              <textarea class="form-control" id="message-text"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-primary">
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
      include("./connection.php");
      // Query to fetch doctor details
      $sql = "SELECT * FROM doctors";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
      ?>
          <div class="col">
            <div class="card">
              <img src="admin/<?php echo $row['image']; ?>" class="card-img-top" alt="Doctor Image">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                <p class="card-text"><?php echo $row['about']; ?></p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Department: <?php echo $row['department']; ?></li>
                <li class="list-group-item">NMC: <?php echo $row['nmc']; ?></li>
                <li class="list-group-item">Experience: <?php echo $row['experience']; ?> Years</li>
              </ul>
              <div class="card-body">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php echo $row['name']; ?>" data-bs-category="<?php echo $row['department']; ?>">
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
  function showDoctorDetails(name, about, department, nmc, experience, qualification,age,mobile,gender) {
    // Populate the modal with doctor details
    document.getElementById('doctorDetailsModalLabel').innerText = name;
    document.getElementById('doctorAbout').innerText = about;
    document.getElementById('doctorDepartment').innerText = 'Department: ' + department;
    document.getElementById('doctorNMC').innerText = 'NMC: ' + nmc;
    document.getElementById('doctorExperience').innerText = 'Experience: ' + experience + ' Years';
    document.getElementById('qualification').innerText = 'Education: ' + qualification ;
    document.getElementById('age').innerText = 'Age: ' + age + ' Years';
    document.getElementById('mobile').innerText = 'Phone: ' + mobile ;
    document.getElementById('gender').innerText = 'Gender: ' + gender ;
    
    // Show the modal
    var doctorDetailsModal = new bootstrap.Modal(document.getElementById('doctorDetailsModal'));
    doctorDetailsModal.show();
  }
</script>


  <script>
    const exampleModal = document.getElementById("exampleModal");
    if (exampleModal) {
      exampleModal.addEventListener("show.bs.modal", (event) => {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const recipient = button.getAttribute("data-bs-whatever");
        const category = button.getAttribute("data-bs-category");
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

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
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>