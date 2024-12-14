<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(isset($_POST['submit2'])) {
    $pid = intval($_GET['pkgid']);
    $useremail = $_SESSION['login'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $comment = $_POST['comment'];
    $status = 0;
    $sql = "INSERT INTO tblbooking(PackageId, UserEmail, FromDate, ToDate, Comment, status) VALUES(:pid, :useremail, :fromdate, :todate, :comment, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':comment', $comment, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Booked Successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
}

// Insert into userpackageviews when a package is viewed
if(isset($_GET['pkgid']) && isset($_SESSION['login'])) {
    $useremail = $_SESSION['login'];
    $pkgid = intval($_GET['pkgid']);
    
    // Insert the user's viewed package into the userpackageviews table
    $insert_sql = "INSERT INTO userpackageviews (PackageID, EmailId) VALUES (:pkgid, :useremail)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->bindParam(':pkgid', $pkgid, PDO::PARAM_INT);
    $stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $stmt->execute();
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>TPSS | Package Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
<script src="js/jquery-ui.js"></script>

<style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
    }
    .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
    }
</style>

<script>
    new WOW().init();
    $(function() {
        $( "#datepicker,#datepicker1" ).datepicker();
    });
</script>

</head>
<body>
<?php include('includes/header.php'); ?>

<div class="banner-3">
    <div class="container">
        <h1 class="wow zoomIn animated" data-wow-delay=".5s"> TPSS - Package Details</h1>
    </div>
</div>

<div class="selectroom">
    <div class="container"> 
        <?php if($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
              else if($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>

        <?php 
        $pid = intval($_GET['pkgid']);
        $sql = "SELECT * from tbltourpackages where PackageId=:pid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pid', $pid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($results as $result) { 
        ?>

        <form name="book" method="post">
            <div class="selectroom_top">
                <div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
                    <img src="images/<?php echo htmlentities($result->PackageImage);?>" class="img-responsive" alt="">
                </div>
                <div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
                    <h2><?php echo htmlentities($result->PackageName);?></h2>
                    <p class="dow">#PKG-<?php echo htmlentities($result->PackageId);?></p>
                    <p><b>Package Type :</b> <?php echo htmlentities($result->PackageType);?></p>
                    <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation);?></p>
                    <p><b>Features</b> <?php echo htmlentities($result->PackageFetures);?></p>
                    <div class="ban-bottom">
                        <div class="bnr-right">
                            <label class="inputLabel">From</label>
                            <input class="date" id="datepicker" type="text" placeholder="dd-mm-yyyy" name="fromdate" required="">
                        </div>
                        <div class="bnr-right">
                            <label class="inputLabel">To</label>
                            <input class="date" id="datepicker1" type="text" placeholder="dd-mm-yyyy" name="todate" required="">
                        </div>
                    </div>
                    <div class="grand">
                        <p>Grand Total</p>
                        <h3>NRP.800</h3>
                    </div>
                </div>
                <h3>Package Details</h3>
                <p><?php echo htmlentities($result->PackageDetails);?></p>
                <div class="selectroom_top">
                    <h2>Travels</h2>
                    <div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms">
                        <ul>
                            <li class="spe">
                                <label class="inputLabel">Comment</label>
                                <input class="special" type="text" name="comment" required="">
                            </li>
                            <?php if($_SESSION['login']) { ?>
                                <li class="spe" align="center">
                                    <button type="submit" name="submit2" class="btn-primary btn">Book</button>
                                </li>
                            <?php } else { ?>
                                <li class="sigi" align="center">
                                    <a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn">Book</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <?php } } ?>

        <!-- Recommended Packages Section -->
        <div class="recommended-packages">
            <h2>Recommended Packages</h2>
            <?php
            if (isset($_SESSION['login'])) {
                $useremail = $_SESSION['login'];
                $conn = new mysqli("localhost", "root", "", "tms");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Recommendation Logic
                function compute_similarity($package1, $package2) {
                    $type_similarity = ($package1['PackageType'] === $package2['PackageType']) ? 1 : 0;
                    $activities1 = explode(", ", $package1['PackageFetures']);
                    $activities2 = explode(", ", $package2['PackageFetures']);
                    $intersection = count(array_intersect($activities1, $activities2));
                    $union = count(array_unique(array_merge($activities1, $activities2)));
                    return 0.7 * $type_similarity + 0.3 * ($union > 0 ? $intersection / $union : 0);
                }

                function build_similarity_matrix($conn) {
                    $packages = [];
                    $result = $conn->query("SELECT * FROM tbltourpackages");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if (isset($row['PackageId'])) {
                                $packages[$row['PackageId']] = $row;
                            }
                        }
                    } else {
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
                    return $similarity_matrix;
                }

                function recommend_packages($useremail, $conn, $similarity_matrix) {
                    $user_packages = [];
                    $stmt = $conn->prepare("SELECT PackageID FROM userpackageviews WHERE EmailId = ?");
                    $stmt->bind_param("s", $useremail);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $user_packages[] = $row['PackageID'];
                    }

                    $recommendations = [];
                    foreach ($user_packages as $packageId) {
                        if (isset($similarity_matrix[$packageId])) {
                            foreach ($similarity_matrix[$packageId] as $similar_package => $similarity_score) {
                                if (!in_array($similar_package, $user_packages)) {
                                    $recommendations[$similar_package] = (isset($recommendations[$similar_package]) ? $recommendations[$similar_package] : 0) + $similarity_score;
                                }
                            }
                        }
                    }

                    arsort($recommendations);
                    return $recommendations;
                }

                $similarity_matrix = build_similarity_matrix($conn);
                $recommendations = recommend_packages($useremail, $conn, $similarity_matrix);

                // Display the recommended packages
                if (!empty($recommendations)) {
                    foreach ($recommendations as $packageId => $score) {
                        $stmt = $conn->prepare("SELECT PackageName, PackageImage, PackageLocation, PackageFetures, PackagePrice, PackageId FROM tbltourpackages WHERE PackageID = ?");
                        $stmt->bind_param("i", $packageId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $package = $result->fetch_assoc();
            ?>
                            <div class="rom-btm">
                                <div class="col-md-4 room-left wow fadeInLeft animated" data-wow-delay=".5s">
                                    <!-- <img src="/tms/images/<?php echo htmlentities($package['PackageImage']); ?>" class="img-responsive" alt=""> -->
                                    <img src="images/<?php echo htmlentities($package['PackageImage']); ?>" 
                                  class="img-responsive" 
                                  alt="" 
                                    onerror="this.onerror=null;this.src='/tms/path/to/placeholder.jpg';">

                                </div>
                                <div class="col-md-5 room-middle wow fadeInUp animated" data-wow-delay=".5s">
                                    <h6><a href="package-details.php?pkgid=<?php echo htmlentities($package['PackageId']); ?>"><?php echo htmlentities($package['PackageName']); ?></a></h6>
                                    <p><b>Package Location:</b> <?php echo htmlentities($package['PackageLocation']); ?></p>
                                    <p><b>Features:</b> <?php echo htmlentities($package['PackageFetures']); ?></p>
                                    <p><b>Price:</b> <?php echo htmlentities($package['PackagePrice']); ?></p>
                                </div>
                                <div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
                                    <a href="package-details.php?pkgid=<?php echo htmlentities($package['PackageId']); ?>" class="btn btn-primary">View Details</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
            <?php
                        }
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
</body>
</html>
