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

            // Insert new Client request into the database 
            $query = "INSERT INTO Client (firstName, lastName, emailAddress, password) 
                      VALUES ('$firstName', '$lastName', '$email', '$password')";

            if (mysqli_query($connection, $query)) {
                // Consultation request added successfully, redirect to client's homepage
               echo "OK";
            } else {
                // Error inserting 
                echo "Error: Unable to add insert request.";
            }
        
   

    // Close database connection
    mysqli_close($connection);



?>
