<?php
include('php-includes/connect.php');
include('php-includes/check-login.php');
$userid = $_SESSION['userid'];
$search = $userid;

// Fetch the actual level from the database based on the logged-in user
$query_level = mysqli_query($con, "SELECT Level FROM tree WHERE userid='$userid'");
if ($query_level && mysqli_num_rows($query_level) > 0) {
    $level_row = mysqli_fetch_assoc($query_level);
    $current_level = $level_row['Level'];
} else {
    // Default to Level 1 if no level is found (this shouldn't happen if the database is consistent)
    $current_level = 1;
}

// If search is performed, adjust the search logic as well
if (isset($_GET['search-id'])) {
    $search_id = mysqli_real_escape_string($con, $_GET['search-id']);
    if ($search_id != "") {
        $query_check = mysqli_query($con, "select * from user where email='$search_id'");
        if (mysqli_num_rows($query_check) > 0) {
            $search = $search_id;
            // Fetch the level of the searched user
            $query_level = mysqli_query($con, "SELECT Level FROM tree WHERE userid='$search'");
            if ($query_level && mysqli_num_rows($query_level) > 0) {
                $level_row = mysqli_fetch_assoc($query_level);
                $current_level = $level_row['Level'];
            }
        } else {
            echo '<script>alert("Access Denied");window.location.assign("tree.php");</script>';
        }
    } else {
        echo '<script>alert("Access Denied");window.location.assign("tree.php");</script>';
    }
}

function tree_data($userid) {
    global $con;
    $data = array();
    $query = mysqli_query($con, "select * from tree where userid='$userid'");
    $result = mysqli_fetch_array($query);
    $data['first'] = $result['first'];
    $data['second'] = $result['second'];
    $data['third'] = $result['third'];
    $data['fourth'] = $result['fourth'];
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mlml Website - Tree</title>
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrapper" style="background-color: #002642">
    <!-- Navigation -->
    <?php include('php-includes/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="font-size:45px">Tree</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-2"></div>
                <form>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <input type="text" name="search-id" class="form-control" required>
                        </div>
                    </div><!-- /.col-lg-8 -->
                    <div class="col-lg-2">
                        <div class="form-group">
                            <input type="submit" name="search" class="btn btn-primary" value="search">
                        </div>
                    </div><!-- /.col-lg-8 -->
                    <div class="col-lg-2"></div>
                </form>   
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table" style="text-align:center">
                            <?php
                            $data = tree_data($search);
                            ?>
                            <!-- Display current level -->
                            <tr height="50">
                                <th colspan="16" style="text-align:center">Level <?php echo $current_level; ?></th>
                            </tr>
                            <!-- Display the current user -->
                            <tr height="150">
                                <td colspan="16"><i class="fa fa-user fa-4x" style="color:#1430B1"></i><p><?php echo $search; ?></p></td>
                            </tr>
                            <!-- Display the next level -->
                            <tr height="50">
                                <th colspan="16" style="text-align:center">Level <?php echo $current_level + 1; ?></th>
                            </tr>
                            <tr height="150">
                                <?php
                                $first_first_user = $data['first'];
                                $first_second_user = $data['second'];
                                $first_third_user = $data['third'];
                                $first_fourth_user = $data['fourth'];

                                function render_user($user, $colspan, $current_level) {
                                    if ($user != "") {
                                        echo "<td colspan='$colspan'><a href='tree.php?search-id=$user&level=$current_level'><i class='fa fa-user fa-4x' style='color:#D520BE'></i><p>$user</p></a></td>";
                                    } else {
                                        echo "<td colspan='$colspan'><i class='fa fa-user fa-4x' style='color:#D520BE'></i><p></p></td>";
                                    }
                                }

                                // Level should only increment for the next row
                                render_user($first_first_user, 4, $current_level + 1);
                                render_user($first_second_user, 4, $current_level + 1);
                                render_user($first_third_user, 4, $current_level + 1);
                                render_user($first_fourth_user, 4, $current_level + 1);
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>
</body>
</html>
