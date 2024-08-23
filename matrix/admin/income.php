<?php
include('php-includes/check-login.php');
require('php-includes/connect.php');
?>
<?php
if(isset($_GET['userid'])){
	$userid = mysqli_real_escape_string($con,$_GET['userid']);
	$amount = mysqli_real_escape_string($con,$_GET['amount']);
	


    $income_query = mysqli_query($con,"select * from income where userid='$userid'");
    $income_array=mysqli_fetch_array($income_query);

    $user_query = mysqli_query($con,"select * from user where under_userid=''");
    $user_array = mysqli_fetch_array($user_query);

    $income_received = $income_array['current_bal'];
    $admin_amount = $user_array['amount']-$income_array['current_bal'];
    $user_amount = $income_array['total_bal']+$income_array['current_bal'];
    $admin_id = $user_array['email'];

    $paid_value = 1;


	$query = mysqli_query($con,"update income set total_bal='$admin_amount' where userid='$admin_id'");

	$query = mysqli_query($con,"update income set total_bal='$user_amount' where userid='$userid'");
	
	$query = mysqli_query($con,"insert into income_received(`userid`, `amount`, `date`) value('$userid', '$income_received', '$date')");
	
    $query = mysqli_query($con,"update income set current_bal=0 where userid='$userid'");
    
    $query = mysqli_query($con, "update user set amount='$user_amount' where email='$userid'");

	$query = mysqli_query($con,"update user set amount='$admin_amount' where email='$admin_id'");

	
	echo '<script>alert("Payment has paid");window.location.assign("income.php");</script>';
}
?>
