<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project Addition | Home & Co</title>
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
        

        <main class="AdditionUpdate"> 
            <h2>Add a New Project</h2><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" name="addition">
    
                <label for="projectName">Project Name:</label>
                <input type="text" id="projectName" name="projectName" required > <br><br>
    
                <label for="projectImage">Upload Image:</label>
                <input type="file" id="projectImage" name="projectImage" accept="image/*" required><br><br>
    

                <label for="designCategory">Design Category:</label>
                <select id="designCategory" name="designCategory" required>
                    <?php
                    session_start();
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);

                    // Establish database connection
                    $conn = new mysqli("localhost", "root", "root", "home");
                    
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch design categories from the database
                    $sql = "SELECT * FROM designcategory";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
                        }
                    }
                    ?>
                </select> <br><br>


                <label for="projectDescription">Project Description:</label><br>
                <textarea id="projectDescription" name="projectDescription" rows="4" cols="50" required></textarea><br><br>
    
                <input type="submit" value="Add Project">
                
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
    
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection
    $conn = new mysqli("localhost", "root", "root", "home");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data); // Remove extra spaces, tabs, and newline characters
        $data = stripslashes($data); // Remove backslashes (\)
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and retrieve form data
    $projectName = sanitize_input($_POST['projectName']);
    $description = sanitize_input($_POST['projectDescription']);
    $designCategoryID = sanitize_input($_POST['designCategory']);
    $designerID = $_SESSION['designer_id'];

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
    if (!in_array($imageFileType, array("jpg", "jpeg", "png", "gif"))) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["projectImage"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["projectImage"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert data into the database using prepared statement
    $stmt = $conn->prepare("INSERT INTO designportfolioproject (designerID, projectName, projectImgFileName, description, designCategoryID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $designerID, $projectName, $targetFile, $description, $designCategoryID);
    if ($stmt->execute()) {
        // Redirect user to designerHome.php upon successful insertion
        header("Location: designerHome.php");
        exit; // Ensure that no further code is executed after the redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close prepared statement
    $stmt->close();

    // Close database connection
    $conn->close();
}
?>
</body>
</html>
