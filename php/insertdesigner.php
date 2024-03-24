<?php
// Check if the form is submitted
    // Include database connection
    $connection = mysqli_connect('localhost', 'u541170206_linaalharbi', '|tR&wAO2', 'u541170206_linaalharbi');
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    


        // Retrieve form data and perform basic validation
        $firstName = ($_POST['firstName']);
        $lastName = ($_POST['lastName']);
        $email = ($_POST['email']);
        $password = ($_POST['password']);
        $password = md5($password);
        $brandName = ($_POST['brandName']);
        $logo=$_FILES['logo']['name'];
        $logotmb=$_FILES['logo']['tmp_name'];
        $upload_file='../Designerlogo/';
        move_uploaded_file($logotmb,$upload_file.$logo);

            // Insert new Designer request into the database 
            $query = "INSERT INTO Designer (firstName, lastName, emailAddress, password, brandName, logoImgFileName) 
                      VALUES ('$firstName', '$lastName', '$email', '$password', '$brandName', '$logo')";

            if (mysqli_query($connection, $query)) {
                // Designer request added successfully
               echo "OK";
            } else {
                // Error inserting Designer request
                echo "Error: Unable to add insert request.";
                
            }
        
   

    // Close database connection
    mysqli_close($connection);



?>
