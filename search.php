<?php
// Display PHP errors for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root"; // Change this as per your setup
$password = "";     // Change this as per your setup
$dbname = "tms";    

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$searchKeyword = '';
$results = [];

// Check if the form has been submitted
if (isset($_POST['search'])) {
    // Sanitize input and assign the keyword
    $searchKeyword = trim($_POST['keyword']);
    
    // Debugging: Check if the keyword is received properly
    //echo "Searching for: " . htmlspecialchars($searchKeyword) . "<br>";
    
    // SQL query to search for the keyword in PackageName, PackageType, or PackageDetails
    $sql = "SELECT * FROM tbltourpackages WHERE PackageName LIKE ? OR PackageType LIKE ? OR PackageDetails LIKE ?";
     
    $stmt = $conn->prepare($sql);

    // Check if the statement is prepared correctly
    if ($stmt === false) {
        die('Error in SQL query: ' . $conn->error);
    }

    // Add wildcards around the keyword for partial matching
    $likeKeyword = "%" . $searchKeyword . "%";

    // Bind the parameters to the SQL query
    $stmt->bind_param("sss", $likeKeyword, $likeKeyword, $likeKeyword);
    
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results
    while ($row = $result->fetch_assoc()) {  
        $results[] = $row;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results for: <?php echo htmlspecialchars($searchKeyword); ?></h1>
    
    <?php if (!empty($results)): ?>
        <h2>Found <?php echo count($results); ?> package(s)</h2>
        <ul>
            <?php foreach ($results as $item): ?>
                <li>
                    <strong><?php echo htmlspecialchars($item['PackageName']); ?></strong><br>
                    <?php echo htmlspecialchars($item['PackageDetails']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No results found for "<?php echo htmlspecialchars($searchKeyword); ?>"</p>
    <?php endif; ?>
    
    <a href="index.php">Back to Homepage</a>
</body>
</html>



