<?php
// Check if the form is submitted
    // Include database connection
    $connection = mysqli_connect('localhost', 'u541170206_linaalharbi', '|tR&wAO2', 'u541170206_linaalharbi');
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    


        // Retrieve form data and perform basic validation
        $userType = ($_POST['userType']);
        $email = ($_POST['email']);
        $password = ($_POST['password']);
        $password = md5($password);


          if ($userType == 'designer'){
            // check Designer from the database 
            $query = "select *  from Designer where emailAddress = '$email' and  password = '$password' ";
            $result = mysqli_query($connection, $query);
            $designerData = mysqli_fetch_assoc($result);
            $count = $result->num_rows;

            if ($count > 0) {
                // Consultation request added successfully, redirect to client's homepage
               echo "designer";
               session_start();
               $designersesionId = $designerData['id'];
            $_SESSION['designer_id']= $designersesionId;

            } else {
                // Error inserting 
                echo "Error: Unable to add insert request.";
            }
          }else if ($userType == 'client'){
               // check Client from the database 
            $query = "select *  from Client where emailAddress = '$email' and  password = '$password' ";
            $result = mysqli_query($connection, $query);
            $ClientData = mysqli_fetch_assoc($result);
            $count = $result->num_rows;

            if ($count > 0) {
                // Consultation request added successfully, redirect to client's homepage
               echo "Client";
               session_start();
               $ClientsesionId = $ClientData['id'];
            $_SESSION['Client_id']= $ClientData;

            } else {
                // Error inserting 
                echo "Error: Unable to add insert request.";
            }
          }
   

    // Close database connection
    mysqli_close($connection);



?>
