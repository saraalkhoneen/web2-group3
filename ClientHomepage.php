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

    <style>

    body {
    background-image: url('img/background.jpg');
    background-size: cover;
    background-position: center;
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    color: #30394e;
    }

    .header {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background-color: #f5f5f5;
    }

    .header h1 {
    margin: 0;
    }
    .logout-link {
        align-self: center;
        text-decoration: none;
        color: #000;
    }
    .content {
        padding: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }
    .filter-section {
        margin-bottom: 20px;
    }

    .designer-table h2 , .request-table h2{
    text-align: center;
    color: #30394e;  
    margin-bottom: 10px; 
    }


    .filter-section select,
    .filter-section button {
    padding: 10px;
    margin-right: 10px;
    }

    .client-info, .designer-table, .request-table {
    margin-bottom: 20px;
    }

    .request-button {
    background-color: #ddd;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    }

    .header h1, .logout-link, label, .request-button, a, table td , .client-info {
    color: #30394e; 
    }


    .client-info {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    }

    .client-detail {
    margin-bottom: 10px;
    }

    .client-detail label {
    font-weight: bold;
    display: block;
    }

    .client-detail div {
    padding: 5px 0;
    }

    .designer-logo, .designer-name {
    text-align: center; 
    }

    .designer-logo {
    margin-bottom: 5px; 
    }

    .designer-logo-img {
    max-width: 100px; /* Adjust the size to your preference */
    max-height: 100px;
    width: auto;
    height: auto;
    display: block; /* This ensures the image is centered within its container */
    margin: 0 auto;
    }



    .content {
    padding: 20px;
    }

    .header-content h1,
    .sign-out-button {
    color: #fff; 
    }

    .white-background-container {
    background-color: rgba(255, 255, 255, 0.8); 
    padding: 20px; 
    margin-top: 20px; 
    margin-bottom: 20px;
    border-radius: 10px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); 
    }

    .filter-section {
    width: auto; 
    max-width: 100%; 
    box-sizing: border-box;
    display: block; 
    margin: 0 auto; 
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 5px;
    }


    .content, .white-background-container {
    box-sizing: border-box;
    width: 100%; 
    padding: 20px; 
    }

    table {
    width: 100%;
    table-layout: fixed;
    }


    .filter-section label {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 18px;
    user-select: none;
    }

    /* Hide the browser's default checkbox */
    .filter-section label input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 5px;
    border: 1px solid #ddd;
    }

    /* On mouse-over, add a grey background color */
    .filter-section label:hover input ~ .checkmark {
    background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .filter-section label input:checked ~ .checkmark {
    background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    }

    /* Show the checkmark when checked */
    .filter-section label input:checked ~ .checkmark:after {
    display: block;
    }

    /* Style the checkmark/indicator */
    .filter-section label .checkmark:after {
    left: 9px;
    top: 5px;
    width: 7px;
    height: 13px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    }

    /* Style the filter button */
    .filter-section button {
    padding: 10px 20px;
    background-color: #30394e;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    }

    .filter-section button:hover {
    background-color: #2196F3;
    }


    </style>
</head>

<body>
    <?php
    session_start();
    include 'db_connect.php'; 

    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'client') {
        header('Location: index.html'); // Adjust redirect as needed
        exit;
    }

    $clientId = $_SESSION['user_id'];
    $queryClient = "SELECT * FROM client WHERE id = '$clientId'";
    $clientResult = mysqli_query($conn, $queryClient);
    $clientData = mysqli_fetch_assoc($clientResult);

    // Fetching all designers for initial load
    $queryDesigners = "SELECT designer.*, designcategory.category AS specialty
                       FROM designer
                       JOIN designerspeciality ON designer.id = designerspeciality.designerID
                       JOIN designcategory ON designerspeciality.designCategoryID = designcategory.id";
    $designersResult = mysqli_query($conn, $queryDesigners);
    ?>

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

    <div class="header">
        <h1>Welcome <?php echo htmlspecialchars($clientData['firstName']); ?></h1>
    </div>

    <div class="content">
        <div class="white-background-container">
            <div class="client-info">
                <div class="client-detail">
                    <label>Client Name:</label>
                    <div><?php echo htmlspecialchars($clientData['firstName'] . ' ' . $clientData['lastName']); ?></div>
                </div>
                <div class="client-detail">
                    <label>Contact Info:</label>
                    <div><?php echo htmlspecialchars($clientData['email']); ?></div>
                </div>
            </div>

            <div class="filter-section">
                <label>Select Categories:</label>
                    <div>
                    <label><input type="checkbox" name="design-category" value="modern"><span class="checkmark"></span> Modern</label>
                    <label><input type="checkbox" name="design-category" value="country"><span class="checkmark"></span> Country</label>
                    <label><input type="checkbox" name="design-category" value="minimalist"><span class="checkmark"></span> Minimalist</label>
                    <label><input type="checkbox" name="design-category" value="scandinavian"><span class="checkmark"></span> Scandinavian</label>
                    <label><input type="checkbox" name="design-category" value="industrial"><span class="checkmark"></span> Industrial</label>
                    <label><input type="checkbox" name="design-category" value="bohemian"><span class="checkmark"></span> Bohemian</label>
                    <label><input type="checkbox" name="design-category" value="coastal"><span class="checkmark"></span> Coastal</label>
                    </div>
                </div>
                <button onclick="filterDesigners()">Filter</button>
            </div>

            <div class="designer-table">
                <h2>Interior Designers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Designer</th>
                            <th>Specialty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($designersResult)) { ?>
                            <tr>
                                <td>
                                    <img src="img/<?php echo $row['logoImgFileName']; ?>" alt="<?php echo htmlspecialchars($row['brandName']); ?>" class="designer-logo-img">
                                    <div class="designer-name"><?php echo htmlspecialchars($row['brandName']); ?></div>
                                </td>
                                <td><?php echo htmlspecialchars($row['specialty']); ?></td>
                                <td><a href="request_consultation.php?designer_id=<?php echo $row['id']; ?>" class="request-button">Request Design Consultation</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <h3>Contact us</h3>
            <ul class="socials">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
            </ul>
        </div>
    </footer>

    <script>
        function filterDesigners() {
            var selectedCategories = Array.from(document.querySelectorAll("input[name='design-category']:checked")).map(input => input.value.toLowerCase());
            var designerRows = document.querySelectorAll(".designer-table tbody tr");

            designerRows.forEach(row => {
                var specialties = row.cells[1].textContent.toLowerCase().split(', ').map(s => s.trim());
                var isMatch = selectedCategories.some(cat => specialties.includes(cat));

                row.style.display = isMatch ? "" : "none";
            });
        }
    </script>
</body>
</html>
