<?php

// delete_project.php
$connection = mysqli_connect("localhost", "root", "", "home");
$error = mysqli_connect_error();

if ($error) {
    die($error);
} else {
    if (isset($_GET['request_id'])) {
        $requestId = $_GET['request_id'];

        // Perform database deletion using the request_id
        $sql = "UPDATE requeststatus SET status = 'Consultation Declined' WHERE id= '$requestId'";

        // Execute the SQL statement
        mysqli_query($connection, $sql);

        // Check if the update was successful
        if (mysqli_affected_rows($connection) > 0) {
            // update was successful
            // Redirect to the designer's homepage
            header('Location: designerHome.php');
            exit;
        } else {
            // update failed
           echo "couldnt decline request";
           header('Location: designerHome.php');
           exit;
        }
    } else {
        echo "no such request!";
    }
}
?>

