<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Home & Co</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatiable" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styleHome.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>

        <div>
            <header>
                <div class="navbar">
                    <div class="icon">
                        <a href="index.html">
                            <img class="logo" src="img/logo.png" alt="DecorDirect Logo">
                        </a>
                    </div>

                    <div class="signout">
                        <ul>
                            <li><a href="logout.php">SIGN OUT</a></li>
                        </ul>
                    </div>
                </div>



        </div>
    </header>
</div>

<?php
session_start();

$connection = mysqli_connect("localhost", "root", "", "home");
$error = mysqli_connect_error();

// Accessing session variables
$designersesionId = $_SESSION['designer_id'];

if ($error) {
    die($error);
} else {
    $query = "SELECT * FROM designer WHERE id = '$designersesionId'";
    $result = mysqli_query($connection, $query);

    // Check if a designer with the given ID exists
    if (mysqli_num_rows($result) > 0) {
        $designerData = mysqli_fetch_assoc($result);
        $firstName = $designerData['firstName'];
        $lastName = $designerData['lastName'];
        $emailAddress = $designerData['emailAddress'];
        $brandName = $designerData['brandName'];
        $logoImgFileName = $designerData['logoImgFileName'];

        $query = "SELECT * FROM designerspeciality WHERE designerID = '$designersesionId'";
        $result = mysqli_query($connection, $query);
        $designerspecialty = mysqli_fetch_assoc($result);
        $designCategoryID = $designerspecialty['designCategoryID'];

        $query = "SELECT * FROM designcategory WHERE id = $designCategoryID";
        $result = mysqli_query($connection, $query);
        $designercategory = mysqli_fetch_assoc($result);
        $specialiy = $designercategory['category'];

        echo "<main>
                <h2 id='welcomeMessage'>Welcome Back! $firstName</h2>
                <h1 class='headerport' id='portfolio'>My Portfolio</h1>
                <div class='organize'>
                    <div id='personalinfo'>
                        <h3>Personal Information</h3>
                        <img id='logo' src='$logoImgFileName' alt='logo'>
                        <h4>First Name:</h4>
                        <h5 id='firstName'>$firstName</h5>
                        <h4>Last Name:</h4>
                        <h5 id='lastName'>$lastName</h5>
                        <h4>Email:</h4>
                        <h5 id='email'>$emailAddress</h5>
                        <h4>Brand Name:</h4>
                        <h5 id='brand'>$brandName</h5>
                        <h4>Speciality:</h4>
                        <h5 id='speciality'>$specialiy</h5>
                    </div> ";

        echo "<div class='tables'>
              <h1 class='headerport'>Design Portoflio</h1>";

        echo "<table id='Designs'>
        <caption><a id='addlink' href='ProjectAddition.html'>Add a new Project</a></caption>
        <tr>
            <th>Project Name</th>
            <th>Image</th>
            <th>Design Category</th>
            <th>Description</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>";

        $query = "SELECT * FROM designportfolioproject WHERE designerid = '$designersesionId'";
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $projectId = $row['id'];
            $projectName = $row['projectName'];
            $projectImgFileName = $row['projectImgFileName'];
            $description = $row['description'];
            $designCategoryID = $row['designCategoryID'];

            $query = "SELECT * FROM designcategory WHERE id = $designCategoryID";
            $categoryResult = mysqli_query($connection, $query);
            $projectCategory = mysqli_fetch_assoc($categoryResult);
            $category = $projectCategory['category'];

            $editLink = "ProjectUpdate.html?id=$projectId"; // Code-generated link based on project ID

            echo "<tr>
            <td>$projectName</td>
            <td><img height='100%' width='100%' src='$projectImgFileName'></td>
            <td>$category</td>
            <td>$description</td>
            <td><a href='$editLink'>Edit</a></td>
            <td><a href='delete_project.php?project_id=<?php echo $projectId; ?>'>Delete</a></td>
          </tr>";
        }

        echo "</table>";

        echo "<h1 class='headerport'>Consultaion Requests</h1>
              <Table id='Requests'>
               <tr>
                <th>Client Name</th>
                <th>Room</th>
                <th>Dimensions</th>
                <th>Design Category</th>
                <th>Color Prefrence</th>
                <th>Date</th>
               </tr>";

        //continue from here
        $query = "SELECT * FROM designconsultationrequest WHERE designerID='$designersesionId'";
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $ClientID = $row['ClientID'];
            $roomTypeID = $row['roomTypeID'];
            $designCategoryID = $row['designCategoryID'];
            $roomWidth = $row['roomWidth'];
            $roomLength = $row['roomLength'];
            $colorPreferences = $row['colorPreferences'];
            $date = $row['date'];
            $statusid = $row['statusID'];

            $query = "SELECT * FROM client WHERE id='$ClientID'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $clientname = $row['firstName'] + ' ' + $row['lastName'];

            $query = "SELECT * FROM roomtype WHERE id='$roomTypeID'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $roomtype = $row['type'];

            $query = "SELECT * FROM designcategory WHERE id='$designCategoryID'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $category = $row['category'];

            $query = "SELECT * FROM requeststatus WHERE id='$statusid'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            if ($row['status'] === 'Pending Consultation') {
                $requestId = $row['id'];
                $acceptLink = "DesignConsultation.html?request_id=$requestId"; // Code-generated link based on request ID
                $declineLink = "DeclineRequest.php?request_id=$requestId"; // Code-generated link based on request ID

                echo "<tr>
                <td>$clientname</td>
                <td>l$roomtype</td>
                <td>$roomWidth</td>
                <td>$category</td>
                <td>$colorPreferences</td>
                <td>$date</td>
                <td><a href='$acceptLink'>Accept</a></td>
                <td><a href='$declineLink'>Decline</a></td>
                </tr>";
            }
        }

        echo "</Table>


      </div>

     </div>
    </main>";
    } else {
        echo "Designer not found.";
    }
}
?>


<footer>
    <div class="footer-content">

        <h3 id="footer-header">Contact us</h3>

        <ul class="socials">
            <li><a href=""><i class="fa fa-facebook"></i></a></li>
            <li><a href=""><i class="fa fa-twitter"></i></a></li>
            <li><a href=""><i class="fa fa-linkedin-square"></i></a></li>
        </ul>

        <div class=”footer-bottom”>
            <p>copyright &copy; 2024 - Home & Co </p>
        </div>

    </div>
</footer>

</body>

</html>
