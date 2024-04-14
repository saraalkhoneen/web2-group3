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
    <?php
    session_start();
    include 'db_connect.php'; // Ensure you have a db_connect.php that handles your database connection settings

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
                    <!-- Example categories for checkbox creation -->
                    <label><input type="checkbox" name="design-category" value="Modern"> Modern</label>
                    <label><input type="checkbox" name="design-category" value="Country"> Country</label>
                    <!-- Add more checkboxes as per your category needs -->
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
