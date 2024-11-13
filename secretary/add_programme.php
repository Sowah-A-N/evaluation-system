<?php
include '../datacon.inc.php';

if (isset($_POST['add'])) {
    $program = mysqli_real_escape_string($conn, $_POST['programme']);
    $p_code = mysqli_real_escape_string($conn, $_POST['programmeCode']);


    // Check for empty fields
    if (empty($program) || empty($p_code) ) {
        echo "<script>alert('Please check your details.'); window.location='add_programme.php';</script>";
        exit();
    } else {
        // Check if Program Name already exists
        $checkClassQuery = "SELECT COUNT(*) as count FROM programme WHERE program = '$program '";
        $result = $conn->query($checkClassQuery);

        if ($result->num_rows > 0) {
            // Class Name already exists
            echo "<script>alert('Class Name already exists. Please enter a different one.'); window.location='add_programme.php';</script>";
            exit();
        } 
        
        $check_query = "SELECT COUNT(*) as count FROM programme WHERE p_code = '$p_code'";
    $result = $conn->query($check_query);

    // Fetch the result row
    $row = $result->fetch_assoc();

    if (isset($row['count']) && $row['count'] > 0) {
        // Staff ID already exists, display an error message
        echo '<script type="text/javascript">alert("Program Code already exists.");window.location=\'add_programme.php\';</script>';
    } 
        else {
            // Insert new class record into the `classes` table
            $insert_query = "INSERT INTO programme (p_code, program) 
                            VALUES ('$p_code', '$program')";

            if ($conn->query($insert_query) === TRUE) {
                echo "<script>alert('New Programme added successfully.'); window.location='add_programme.php';</script>";
            } else {
                echo "Error adding class: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Programme</title>

    

    <link rel="stylesheet" href="css/style.css">
</head>

  <body>
    
         
 
  
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row" id="proBanner">
            </div>
            <div class="d-xl-flex justify-content-between align-items-start">
              <h2 class="text-dark font-weight-bold mb-2"> List of Programmes </h2>
              <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                <div class="dropdown ml-0 ml-md-4 mt-2 mt-lg-0">
                  <button class="btn btn-outline-primary" type="button" id="dropdownMenuButton1" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#exampleModal"> Add a New Program</button>
                  <button class="btn btn-outline-success" type="button" id="uploadExcelButton" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#uploadExcelModal"> Upload Excel File</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border {">
                </div>
                <div class="tab-content tab-transparent-content overflow-auto">
                  <div class="tab-pane fade show active" id="business-1" role="tabpanel" aria-labelledby="business-tab">
                    <div class="row">
<!--Table goes here -->
                        <?php
                        $sql="SELECT * FROM programme ";
                        $result=mysqli_query($conn, $sql);
                        if (!$result) {
                            printf("Error: %s\n", mysqli_error($conn));
                            exit();
                        } ?>
                        <br />
                      <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">S/n</th>
                          <th scope="col">Programme Name</th>
                          <th scope="col">Programme Code</th>
                        
                        </tr>
                      </thead>
                      <tbody>
                                          <?php
                    $serial_number = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>$serial_number</td>";
                        echo "<td>" . $row['program'] . "</td>";
                        echo "<td>" . $row['p_code'] . "</td>";
                       

                        // Add form within the loop to ensure each row has its own form
                        echo "<form action='add_inc_programme.php' method='POST'>";
                        echo "<input type='hidden' name='id' value='" . $row['t_id'] . "'>";
                       
                        
                        echo "</form>";

                        echo "</tr>";

                        $serial_number++;
                    }
                    ?>
  
                    
                    </div></p>
                            </div>
                      </div>
                      <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Enter New Programme</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>

                                <div class="modal-body">
                                <form method="POST" action="" name="add_programme">
                                   

                                <div class="form-group">
                                  <label for="staffName">Programme Code:</label>
                                    <input type="text" class="form-control" name="programmeCode" id="programmeCode" placeholder="Enter Programme Code" required oninput="capitalizeFirstLetter(this)">
                                  </div>

                                  <div class="form-group">
                                  <label for="staffName"> Name of Programme:</label>
                                    <input type="text" class="form-control" name="programme" id="programme" placeholder="Enter Programme Name" required oninput="capitalizeFirstLetter(this)">
                                  </div>

                                 
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-success" name="add" >Submit</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
         



<!-- 
                                                Upload Excel Modal -->
                        <!-- <div class="modal fade" id="uploadExcelModal" tabindex="-1" role="dialog" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="uploadExcelModalLabel">Upload Excel File</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                  <div class="form-group">
                                    <label for="excelFile">Choose Excel File:</label>
                                    <input type="file" class="form-control" name="excelFile" id="excelFile" accept=".xls, .xlsx" required>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="" class="btn btn-success" name="upload">Upload</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div> --> 

                          <script>









                    function capitalizeFirstLetter(input) {
                                // Capitalize the first letter of each word
                                input.value = input.value.replace(/\b\w/g, (char) => char.toUpperCase());
                            }
                        ;
                    </script>
                       



  </body>
</html>