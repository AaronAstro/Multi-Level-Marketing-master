<?php

include('php-includes/connect.php');

if(isset($_POST['submit-btn'])){
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $name = mysqli_real_escape_string($con, $filter_name);

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = mysqli_real_escape_string($con, $filter_email);

	$filter_mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = mysqli_real_escape_string($con, $filter_mobile);

	$filter_address = filter_var($_POST['address'], FILTER_SANITIZE_SPECIAL_CHARS);
    $address = mysqli_real_escape_string($con, $filter_address);

	$filter_account = filter_var($_POST['account'], FILTER_SANITIZE_SPECIAL_CHARS);
    $account = mysqli_real_escape_string($con, $filter_account);

	$filter_amount = filter_var($_POST['amount'], FILTER_SANITIZE_SPECIAL_CHARS);
    $amount = mysqli_real_escape_string($con, $filter_amount);

	$filter_password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = mysqli_real_escape_string($con, $filter_password);

    $filter_cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_SPECIAL_CHARS);
    $cpassword = mysqli_real_escape_string($con, $filter_cpassword);

    $select_user = mysqli_query($con, "SELECT * FROM `user` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0){

            $message = 'user already exists';

    }
    else {
        if($password != $cpassword){
            $message = 'wrong password';
        }else{
            mysqli_query($con, "INSERT INTO `user`(name, email, password, mobile, address, account, amount) VALUES ('$name', '$email', '$password','$mobile' ,'$address' ,'$account','$amount')") or die('query failed');
			$query = mysqli_query($con,"insert into tree(`userid`, `Level`) values('$email', 1)");
      $query = mysqli_query($con,"insert into income (`userid`) values('$email')");
            $message[] = 'Registered successful';
            header('location:index.php');
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


  <title> Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor1/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css1/sb-admin-2.css" rel="stylesheet">

</head>

<body class="" style="background-color: #002642">

  <div class="container" style=" margin-top: 6% ">


<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9 col-sm-12">

    <div class="card border-0 shadow-lg my-5">
      <div class="card-body p-0">
      
        <div class="row">
          <div class="col-md-6 col-12 d-lg-block bg-login-image"> <img src="Butter2.png" style="display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;"></div>
          <div class="col-lg-6 col-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4" style="margin-top: 20px ; font-size: 30px"><b>Please Sign Up To Droxford Agency!</b></h1>
              </div>
              <form method="post">
                            <fieldset>
							<div class="form-group" style="margin-top: 20px; ">
                                  <input class="form-control" placeholder="Full Name" name="name">
                                </div>
                                <div class="form-group" style="margin-top: 20px; ">
                                  <input class="form-control" placeholder="E-mail" name="email" type="email">
                                </div>
								<div class="form-group" style="margin-top: 20px; ">
                                  <input class="form-control" placeholder="Mobile" name="mobile" type="number">
                                </div>
								<div class="form-group" style="margin-top: 20px; ">
                                  <input class="form-control" placeholder="Address" name="address">
                                </div>
								<div class="form-group" style="margin-top: 20px; ">
                                  <input class="form-control" placeholder="Account Number" name="account" type="number">
                                </div>
								<div class="form-group" style="margin-top: 20px; ">
                                  <input class="form-control" placeholder="Amount" name="amount" type="number">
                                </div>
                                <div class="form-group" style="margin-top: 25px">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
								<div class="form-group" style="margin-top: 20px; ">
                                  <input class="form-control" placeholder="Confirm Pasword" name="cpassword" type="password">
                                </div>    
                                <button type="submit"  class="btn btn-lg btn-success btn-block" name="submit-btn" style="margin-top: 30px">Sign up
                                </button><br />
                                <!--<div class="" style="margin-right: auto;
                                                     margin-left: auto;
                                                     text-align: center;
                                                     font-size: 22px" >
                                                     <a href="#" style="">Forget Password?</a><br /><br />
                                </div> -->
                            </fieldset>
                        </form>
              </form>
            
             
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</div>

<div class="container" style=" margin-top: 2% ">


<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9 col-sm-12">

    <div class="card border-0 shadow-lg my-5">
      <div class="card-body p-0">
      
        <div class="row" style="background-color: #002642">
          <!-- <div class="col-lg-6 col-12"> -->
            <div class="p-5">
              <!-- <div class="text-center"> -->
                <ul><h1 class="h4 text-gray-900 mb-4" style="margin-top: 10px; font-size:35px"><b style="color: #fff ">CONTACT DETAILS</b></h1>
                <li style="color: #fff; font-size: 20px ">Phone Number: +917015737012 ; +918168858453</li>
                <li  style="color: #fff; font-size: 20px ">Email: cleanalya.ltd@gmail.com</li>
                </ul>
</div>
             
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</div>
    <script src="vendor/jquery/jquery.min.js"></script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor1/jquery/jquery.min.js"></script>
  <script src="vendor1/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor1/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>