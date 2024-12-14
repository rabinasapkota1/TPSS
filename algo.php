<?php
session_start(); // Start the session

// Check if useremail exists in session
if (isset($_SESSION['login'])) {
    $useremail = $_SESSION['login'];
    // Database connection
    $conn = new mysqli("localhost", "root", "", "tms");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to compute similarity between two packages
    function compute_similarity($package1, $package2) {
        // Compare types
        $type_similarity = ($package1['PackageType'] === $package2['PackageType']) ? 1 : 0;
        
        // Compare activities using Jaccard similarity
        $activities1 = explode(", ", $package1['PackageFetures']);  // Features stored as comma-separated string
        $activities2 = explode(", ", $package2['PackageFetures']);
        $intersection = count(array_intersect($activities1, $activities2));
        $union = count(array_unique(array_merge($activities1, $activities2)));
        $activity_similarity = $union > 0 ? $intersection / $union : 0;

        // Weighted similarity (you can adjust the weights)
        return 0.7 * $type_similarity + 0.3 * $activity_similarity;
    }

    // Build similarity matrix
    function build_similarity_matrix($conn) {
        $packages = [];
        $result = $conn->query("SELECT * FROM tbltourpackages");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Ensure the row contains 'PackageID' before adding it to the array
                if (isset($row['PackageId'])) {
                    $packages[$row['PackageId']] = $row;
                }
            }
        } else {
            echo "No packages found in the database.";
            return [];
        }
        
        $similarity_matrix = [];
        foreach ($packages as $id1 => $package1) {
            foreach ($packages as $id2 => $package2) {
                if ($id1 !== $id2) {
                    $similarity_matrix[$id1][$id2] = compute_similarity($package1, $package2);
                }
            }
        }
       // print_r($similarity_matrix);
        return $similarity_matrix;
    }

    // Recommend packages for a user based on viewed packages
    function recommend_packages($useremail, $conn, $similarity_matrix) {
        // Get the list of packages the user has viewed
        $user_packages = [];
        $stmt = $conn->prepare("SELECT PackageID FROM userpackageviews WHERE EmailId = ?");
        $stmt->bind_param("s", $useremail);  // Securely bind the userId
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $user_packages[] = $row['PackageID'];
        }

        // Calculate recommendation scores based on similarity to user-viewed packages
        $recommendations = [];
        foreach ($user_packages as $packageId) {
            if (isset($similarity_matrix[$packageId])) { // Ensure the package exists in the similarity matrix
                foreach ($similarity_matrix[$packageId] as $similar_package => $similarity_score) {
                    if (!in_array($similar_package, $user_packages)) {
                        $recommendations[$similar_package] = (isset($recommendations[$similar_package]) ? $recommendations[$similar_package] : 0) + $similarity_score;
                    }
                }
            }
        }

        // Sort recommendations by similarity score in descending order
        arsort($recommendations);
        return $recommendations;
    }

    // Main Logic
    $similarity_matrix = build_similarity_matrix($conn);
    $recommendations = recommend_packages($useremail, $conn, $similarity_matrix);
    

    //Display the result
    echo "<h2>Recommended Packages for User: $useremail based on Packages You Viewed:</h2>";
    if (!empty($recommendations)) {
        foreach ($recommendations as $packageId => $score) {
            $stmt = $conn->prepare("SELECT PackageName, PackageType, PackageImage, PackageLocation, PackageFetures, PackagePrice, PackageId FROM tbltourpackages WHERE PackageID = ?");
            $stmt->bind_param("i", $packageId);  // Securely bind the PackageID
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $package = $result->fetch_assoc(); // Fetch the package data
                
                ?>
                <div class="rom-btm">
                    <div class="col-md-4 room-left wow fadeInLeft animated" data-wow-delay=".5s">
                        <img src="admin/PackageImage/<?php echo htmlentities($package['PackageImage']); ?>" class="img-responsive" alt="">
                    </div>
                    <div class="col-md-5 room-middle wow fadeInUp animated" data-wow-delay=".5s">
                        <h4>Package Name: <?php echo htmlentities($package['PackageName']); ?></h4>
                        <h6>Package Type: <?php echo htmlentities($package['PackageType']); ?></h6>
                        <p><b>Package Location:</b> <?php echo htmlentities($package['PackageLocation']); ?></p>
                        <p><b>Features:</b> <?php echo htmlentities($package['PackageFetures']); ?></p>
                    </div>
                    <div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
                        <h5>NRP <?php echo htmlentities($package['PackagePrice']); ?></h5>
                        <a href="package-details.php?pkgid=<?php echo htmlentities($package['PackageId']); ?>" class="view">Details</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
            } else {
                echo "Package not found.";
            }
        }
    } else {
        echo "<p>No recommendations available.</p>";
    }

} else {
    echo "No user ID found in session. Please log in.";
}
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
       
    </style>
    <title>Package Recommendations</title>
</head>

</html>
