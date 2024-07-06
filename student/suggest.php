<?php
session_start();
include "../include/connect.php";

$file_error = null;

if (isset($_SESSION["id"])) {
    $user_id = $_SESSION["id"];
    $sql = mysqli_query($connect, "SELECT * FROM `student` WHERE id = $user_id");

    if ($sql) {
        $fetch = mysqli_fetch_assoc($sql);
        $firstname = $fetch["firstname"];
        $lastname = $fetch["lastname"];
        $othername = $fetch["othername"];
        $matricno = $fetch["matricno"];
        $level = $fetch["level"];
        $email = $fetch["email"];
        $photos = $fetch["photos"];

        $modified_lastname = strtoupper($lastname);
    }

    if (isset($_POST["submit"])) {
        $supervisor_fullname = $_POST["supervisor_fullname"];
        $supervisor_email = $_POST["supervisor_email"];
        $project_tittle1 = $_POST["project_tittle1"];
        $project_description1 = $_POST["project_description1"];
        $project_tittle2 = $_POST["project_tittle2"];
        $project_description2 = $_POST["project_description2"];
        $project_tittle3 = $_POST["project_tittle3"];
        $project_description3 = $_POST["project_description3"];
        $fullname = "{$firstname} {$lastname}";
        
// IF your project was already approved, decline request
    $sql = mysqli_query($connect,"SELECT * FROM `approved_suggestion` WHERE student_name = '$fullname'");

    if (mysqli_num_rows($sql) > 0) {
        echo '<script>alert("Your suggestion has already been approved\nTherefore, your suggestion has been declined!");</script>';
    }else {
        $sql2 = mysqli_query($connect,"SELECT * FROM `project_suggestion` WHERE student_name = '$fullname'");

        if (mysqli_num_rows($sql2) > 0) {
            echo "<script>alert('Already made project suggestion, wait for your supervisors Feedback!');</script>";
        }else {

            // INSERTING FIRST SUGGESTION
            $sql3 = mysqli_query($connect, "INSERT INTO `project_suggestion`(student_name,project_tittle,project_description,`supervisor's_name`,`supervisor's_email`) VALUES('$fullname','$project_tittle1','$project_description1','$supervisor_fullname','$supervisor_email')");

            // INSERTING SECOND SUGGESTION
            $sql4 = mysqli_query($connect, "INSERT INTO `project_suggestion`(student_name,project_tittle,project_description,`supervisor's_name`,`supervisor's_email`) VALUES('$fullname','$project_tittle2','$project_description2','$supervisor_fullname','$supervisor_email')");

            // INSERTING THIRD SUGGESTION
            $sql5 = mysqli_query($connect, "INSERT INTO `project_suggestion`(student_name,project_tittle,project_description,`supervisor's_name`,`supervisor's_email`) VALUES('$fullname','$project_tittle3','$project_description3','$supervisor_fullname','$supervisor_email')");
        
            if ($sql3 && $sql4 && $sql5) {
                echo "<script>alert('suggestion succcessfuly sent!');</script>";
            } else {
                echo "SQL query failed. Check for errors: " . mysqli_error($connect);
                die();
            }
        }
    }

        
    }

} else {
    header("location:../login.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NSUK PROJECTS APP</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <link rel="stylesheet" href="/styles.css">
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.php-->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="index.php">
                    <h3 style="color: white;">NSUK</h3>
                </a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle " src="<?php echo $photos; ?>" alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal"><?php echo $modified_lastname; ?></h5>
                                <span>STUDENT</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item nav-category"> 
                    <span class="nav-link">Navigation</span>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="index.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="project.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-folder-search"></i>
                        </span>
                        <span class="menu-title">Browse Projects</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="suggest.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-magnify-plus-outline"></i>
                        </span>
                        <span class="menu-title">Suggest project topic</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="./approval.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-check"></i>
                        </span>
                        <span class="menu-title">Project approval</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="./upload.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-upload"></i>
                        </span>
                        <span class="menu-title">Upload project</span>
                    </a>
                </li>
                
                <li class="nav-item menu-items">
                    <a class="nav-link" href="./feedback.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-comment-account"></i>
                        </span>
                        <span class="menu-title">Feedback</span>
                    </a>
                </li>
            </ul>
        </nav>
            <!-- partial -->
            <div class="main-panel ">
                <div class="content-wrapper">

                    <div class="container mt-5">
                        <h2 class="mb-5">Project topic suggestion</h2>
                        <form action="suggest.php" method="POST" enctype="multipart/form-data">
                            <!-- SUPERVISOR'S FULLNAME -->
                        <select class="form-control bg-white mb-3" name="supervisor_fullname" required>
                        <option selected>--- Select Supervisor's Full Name---</option>
                            <?php
                                $select_supervisor = mysqli_query($connect,"SELECT * FROM `supervisor`");
                                

                                while ($row_supervisor = mysqli_fetch_assoc($select_supervisor)) {
                                    $supervisorFullname = $row_supervisor["firstname"] . " ". $row_supervisor["lastname"] . " " . $row_supervisor["othername"];

                                    echo '
                                        <option value="'. $supervisorFullname .'">'. $supervisorFullname .'</option>
                                    ';
                                }

                            ?>
                            </select>  

                                    <!-- SUPERVISOR'S EMAIL -->
                        <select class="form-control bg-white mb-5" name="supervisor_email" required>
                        <option selected>--- Select Supervisor's Email Address---</option>
                            <?php
                                $select_supervisor = mysqli_query($connect,"SELECT * FROM `supervisor`");
                                

                                while ($row_supervisor = mysqli_fetch_assoc($select_supervisor)) {
                                    $supervisorEmail = $row_supervisor["email"];

                                    echo '
                                        <option value="'. $supervisorEmail .'">'. $supervisorEmail .'</option>
                                    ';
                                }

                            ?>
                            </select>  

                            
                            <div class="form-group">
                                <label for="projectTitle">Project Title 1</label>
                                <input type="text" name="project_tittle1" class="form-control text-light" placeholder="Enter project title" required>
                            </div>
                            <div class="form-group mb-5">
                                <label for="projectDescription">Project Description 1</label>
                                <textarea class="form-control text-light" name="project_description1" id="projectDescription" rows="4" placeholder="Enter project description" required></textarea>
                            </div>
                            

                            <div class="form-group">
                                <label for="projectTitle">Project Title 2</label>
                                <input type="text" name="project_tittle2" class="form-control text-light" placeholder="Enter project title" required>
                            </div>
                            <div class="form-group mb-5">
                                <label for="projectDescription">Project Description 2</label>
                                <textarea class="form-control text-light" name="project_description2" id="projectDescription" rows="4" placeholder="Enter project description" required></textarea>
                            </div>
                            

                            <div class="form-group">
                                <label for="projectTitle">Project Title 3</label>
                                <input type="text" name="project_tittle3" class="form-control text-light" placeholder="Enter project title" required>
                            </div>
                            <div class="form-group">
                                <label for="projectDescription">Project Description 3</label>
                                <textarea class="form-control text-light" name="project_description3" id="projectDescription" rows="4" placeholder="Enter project description" required></textarea>
                            </div>
                            
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                



                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function logout(){
            if (confirm("You are about to logout!")) {
                window.location.href="logout.php";
            }
        }
    </script>

    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>

</html>