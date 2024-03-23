<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project Update | Home & Co</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleaddition.css">
    <link rel="stylesheet" href="styleHome.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="main">
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
        </header>

        <?php
        session_start();
        $connection = mysqli_connect("localhost", "root", "root", "home");
        $error = mysqli_connect_error();
        if ($error) {
            die($error);
        }

        // Accessing session variables
        $designerId = $_SESSION['designer_id'];
        $projectId = $_GET['id']; // Retrieve project ID from URL parameter

        $query = "SELECT * FROM designportfolioproject WHERE designerid = '$designerId' AND id = '$projectId'";
        $result = mysqli_query($connection, $query);

        // Check if project with the given ID exists
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $projectName = $row['projectName'];
            $projectImgFileName = $row['projectImgFileName'];
            $projectDescription = $row['description'];
            $projectCategoryID = $row['designCategoryID'];
        } else {
            echo "Project not found.";
        }

        // Check if form data is submitted via POST method
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $projectName = $_POST['projectName'];
            $designCategoryId = $_POST['designCategory'];
            $projectDescription = $_POST['projectDescription'];

            // Check if a new image file is uploaded
            if ($_FILES['projectImage']['error'] === UPLOAD_ERR_OK) {
                $projectImg = $_FILES['projectImage']['name'];
                // File upload handling
                $targetDir = "img/"; // Directory where the files will be stored
                $targetFile = $targetDir . basename($_FILES["projectImage"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["projectImage"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["projectImage"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow only certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["projectImage"]["tmp_name"], $targetFile)) {
                        echo "The file " . htmlspecialchars(basename($_FILES["projectImage"]["name"])) . " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                $projectImg = $projectImgFileName; // No new image uploaded, retain the existing image file name
            }

            // Sanitize inputs
            $projectId = mysqli_real_escape_string($connection, $projectId);
            $projectName = mysqli_real_escape_string($connection, $projectName);
            $projectImg = mysqli_real_escape_string($connection, $projectImg);
            $designCategoryId = mysqli_real_escape_string($connection, $designCategoryId);
            $projectDescription = mysqli_real_escape_string($connection, $projectDescription);

            // Update the table with the new project details
            $query = "UPDATE designportfolioproject 
                      SET projectName='$projectName', 
                          projectImgFileName='$projectImg',
                          designCategoryID='$designCategoryId', 
                          description='$projectDescription' 
                      WHERE id='$projectId'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                // Redirect user to designerHome.php
                header("Location: designerHome.php");
                exit();
            } else {
                echo "Error updating project: " . mysqli_error($connection);
            }
        }
        ?>

        <main class="AdditionUpdate">
            <h2>Update a Project</h2><br>
            <form action="ProjectUpdate.php?id=<?php echo $projectId; ?>" method="post" enctype="multipart/form-data">

                <label for="projectName">Project Name:</label>
                <input type="text" id="projectName" name="projectName" value="<?php echo $projectName; ?>"> <br><br>

                <label for="projectImage">Upload Image:</label><br>
                <input type="file" id="projectImage" name="projectImage"><br>
                <img id="preview" src="<?php echo $projectImgFileName; ?>" alt="Default Image" style="max-width: 150px; max-height: 150px;"><br><br>
                <!-- Hidden input to pass the project's img in case user didnt update it-->
                <input type="hidden" name="projectImgFileName" value="<?php echo htmlspecialchars($projectImgFileName); ?>">

                <label for="designCategory">Design Category:</label>
                <select id="designCategory" name="designCategory">
                    <?php
                    // Fetch design categories from the database to show the project's as default 
                    $sql = "SELECT * FROM designcategory WHERE id = $projectCategoryID";
                    $result = mysqli_query($connection, $sql);

                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
                        }
                    }

                    // Fetch design categories excluding the project's category
                    $sql = "SELECT * FROM designcategory WHERE id != $projectCategoryID";
                    $result = mysqli_query($connection, $sql);

                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
                        }
                    }
                    ?>
                </select> <br><br>

                <label for="projectDescription">Project Description:</label><br>
                <textarea id="projectDescription" name="projectDescription" rows="4" cols="50"><?php echo $projectDescription; ?></textarea><br><br>

                <input type="submit" value="Update Project">
            </form>
        </main>

        <footer>
            <div class="footer-content">
                <h3 id="footer-header">Contact us</h3>
                <ul class="socials">
                    <li><a href=""><i class="fa fa-facebook"></i></a></li>
                    <li><a href=""><i class="fa fa-twitter"></i></a></li>
                    <li><a href=""><i class="fa fa-linkedin-square"></i></a></li>
                </ul>
                <div class="footer-bottom">
                    <p>copyright &copy; 2024 - Home & Co </p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
