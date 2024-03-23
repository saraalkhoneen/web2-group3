<?php

// delete_project.php
$connection = mysqli_connect("localhost", "root", "", "home");
$error = mysqli_connect_error();

if ($error) {
    die($error);
} else {
    if (isset($_GET['project_id'])) {
        $projectId = $_GET['project_id'];

        // Perform database deletion using the project_id
        $sql = "DELETE FROM designportfolioproject WHERE id = '$projectId'";

        // Execute the SQL statement
        mysqli_query($connection, $sql);

        // Check if the deletion was successful
        if (mysqli_affected_rows($connection) > 0) {
            // Deletion was successful
            // Redirect to the designer's homepage
            header('Location: designerHome.php');
            exit;
        } else {
            // Deletion failed
           echo "couldnt delete project";
           header('Location: designerHome.php');
           exit;
        }
    } else {
        echo "no such project!";
    }
}
?>

