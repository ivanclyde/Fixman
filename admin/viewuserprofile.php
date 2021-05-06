 <?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../config.php');

	  $user = $_SESSION['userid'];
		$userid = $_GET['userid'];

		$users = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
    while ($user = mysqli_fetch_array($users)) 
    {
        $fname = $user['fname'];
        $mname = $user['mname'];
        $lname = $user['lname'];
        $age = $user['age'];
        $bdate = $user['bdate'];
        $newbdate = date('F d, Y', strtotime($user['bdate']));
        $address = $user['address'];
        $contactno = $user['contactno'];
        $gender = $user['gender'];
        $profilepix = $user['profilepix'];
        $email = $user['email'];
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
		  <meta charset="utf-8">
      <link rel="icon" href="../images/fixmanlogo.png">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style type="text/css">
body {
  font-family: Century Gothic, Arial, sans-serif, !important;
  height: auto; 
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  font-size: 1.5em !important;
}
</style>
</head>
<body>
<?php include('adminheader.php')?>

<div class="row" style="margin-top:-15px">
  <div class="col-sm-3" style="width:300px !important;background-color:#F1F1F1;height:551px">
    <button class="btn btn-light" onclick="location.href='adminviewusers.php';"/><span class="glyphicon glyphicon-chevron-left">&nbsp</span>Back</button>
      <center><div class="img_div">
          <br>
          <img src="../profilepix/<?php echo $profilepix ?>" style="width:200px;height:200px;border-radius:100px">
          <h3><?php echo $fname ?> <?php echo $lname ?></h3>
          <a class="btn btn-warning" href="viewuserprofile.php?userid=<?php echo$userid ?>" style="width:150px;margin-bottom:5px">Profile</a>
          <a class="btn btn-info" href="useractivitylog.php?userid=<?php echo$userid ?>" style="width:150px;margin-bottom:5px">Activity Log</a>
        </div></center>
  </div>
  <div class="col-sm-9">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-info">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <p role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="collapseOne"></p>
                  <h4><b>User Profile</b></h4>
                </a>
              </h4>
            </div>
            <div align="left" id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <table style="font-size:1.2em">
                <tr>
                  <td><b>First Name</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$fname?></td>
                </tr>
                <tr>
                  <td><b>Middle Name</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$mname?></td>
                </tr>
                <tr>
                  <td><b>Last Name</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$lname?></td>
                </tr>
                <tr>
                  <td><b>Age</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$age?></td>
                </tr>
                <tr>
                  <td><b>Birthdate</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$newbdate?></td>
                </tr>
                <tr>
                  <td><b>Address</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$address?></td>
                </tr>
                <tr>
                  <td><b>Contact Number</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$contactno?></td>
                </tr>
                <tr>
                  <td><b>Gender</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$gender?></td>
                </tr>
                <tr>
                  <td><b>Email Address</b></td>
                  <td>&emsp;: </td>
                  <td>&emsp;<?php echo$email?></td>
                </tr>
              </table>
              </div>
            </div>
          </div>
        </div>
  </div>
</div>

</body>
</html>
