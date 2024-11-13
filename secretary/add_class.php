<?php
include '../datacon.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Class</title>
    <!-- Include Flatpickr library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="css/style.css">
</head>

  <body>
    
         
 
  
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row" id="proBanner">
            </div>
            <div class="d-xl-flex justify-content-between align-items-start">
              <h2 class="text-dark font-weight-bold mb-2"> List of Classes </h2>
              <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                <div class="dropdown ml-0 ml-md-4 mt-2 mt-lg-0">
                  <button class="btn btn-outline-primary" type="button" id="dropdownMenuButton1" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#exampleModal"> Add a New Department</button>
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
                        $sql="SELECT * FROM classes ";
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
                          <th scope="col">Class Name </th>
                          <th scope="col">Programme</th>
                          <th scope="col">department</th>
                          <th scope="col">Date of Enrollment</th>
                          <th scope="col">Date of Completion</th>


                          
                        </tr>
                      </thead>
                      <tbody>
                                          <?php
                    $serial_number = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>$serial_number</td>";
                        echo "<td>" . $row['class_name'] . "</td>";
                        echo "<td>" . $row['programme'] . "</td>";
                        echo "<td>" . $row['department_id'] . "</td>";
                        echo "<td>" . $row['class_year_start'] . "</td>";
                        echo "<td>" . $row['class_year_end'] . "</td>";
                       

                        // Add form within the loop to ensure each row has its own form
                        echo "<form action='add_class_inc.php' method='POST'>";
                        echo "<input type='hidden' name='id' value='" . $row['class_id'] . "'>";
                       
                        
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
                                  <h5 class="modal-title" id="exampleModalLabel">Enter New Class</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>

                                <div class="modal-body">
                                <form method="POST" action="add_class_inc.php" name="add_class">

                                  <div class="form-group">
                                  <label for="staffName">Class Name:</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Class Name" required oninput="capitalizeFirstLetter(this)">
                                  </div>

                                  

                                  <div class="form-group">
                            <label for="category">Programme:</label>
                            <select id="programme" name="programme" data-array-id="programme" onchange="" >
                    <option hidden value="">Select  Programme</option>
                    <?php
                    $sql = "SELECT * FROM programme ";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);

                    do {
                        echo "<option value='" . $row['t_id'] . "' data-value='". $row['t_id'] ."'>" . $row['programme'] . "</option>";
                    } while ($row = mysqli_fetch_array($result));
                    echo "</select>"; 
                    ?>
                        </div>


                        

                        <div class="form-group">
                            <label for="category">Department:</label>
                            <select id="department" name="department" data-array-id="department" onchange="" >
                    <option hidden value="">Select  Department</option>
                    <?php
                    $sql = "SELECT * FROM departments ";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);

                    do {
                        echo "<option value='" . $row['department_id'] . "' data-value='". $row['department_id'] ."'>" . $row['department_name'] . "</option>";
                    } while ($row = mysqli_fetch_array($result));
                    echo "</select>"; 
                    ?>



                        </div>


                        <div class="form-group">
                        <label for="acquisition_date_start" class="control-label">Year of Enrollment:</label>
                        <input type="text" id="date_start" name="date_start" placeholder="Year of Enrollment" required>

                        </div>

                        <div class="form-group">
                        <label for="date_end">Year of Completion:</label>
                        <input type="text" id="date_end" name="date_end"  placeholder="Year of Completion"  required>

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