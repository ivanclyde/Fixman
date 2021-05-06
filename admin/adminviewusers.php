<?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../config.php');

	$user = $_SESSION['userid'];

	$result = mysqli_query($database, "SELECT * FROM users WHERE user_type = 'Customer' AND status = 'Verified' ORDER BY userid DESC");

	if (isset($_GET['userid'])) 
	{
		$userid = $_GET['userid'];

		$sql = "DELETE FROM users WHERE userid = '$userid'";
		$res = mysqli_query($database, $sql);

		echo "<script>alert('User Deleted Successfully'); window.location.href='admin/adminviewcustomers.php';</script>";
	}

	$badge = mysqli_query($database, "SELECT * FROM repairman WHERE status='Pending'");
	$count = mysqli_num_rows($badge);
?>

<!DOCTYPE html>
<html>
<head>
	<title>List of Customer</title>
		  <meta charset="utf-8">
		  <link rel="icon" href="../images/fixmanlogo.png">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style type="text/css" rel="stylesheet">
body {
  font-family: Century Gothic, Arial, sans-serif, !important;
  height: auto; 
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  font-size: 1.5em !important;
}
.btn {
  width: 223px;
  margin-top:5px;
}
</style>
</head>
<body>
<?php include('adminheader.php')?>

<div class="row" style="margin-top:-15px">
	<div class="col-sm-3 text-center" style="background-color:#F1F1F1;height:553px"><br>
		<div class="image">
			<img src="../images/mana.png" style="height:200px;width:200px;border-radius:100px">
		</div>
		<a class="btn btn-info" href="adminhomepage.php">Overview</a><br>
		<a class="btn btn-warning" href="adminviewusers.php">View All Users</a><br>
		<a class="btn btn-info" href="adminviewrepairman.php">View All Repairman</a><br>
		<a class="btn btn-info" href="adminviewapplications.php">View Repairman Applications <span class="badge badge-light" style="background-color:red"><?php if(mysqli_num_rows($badge) != 0){echo $count;}else{}?></span></a>
	</div>
	<div class="col-md-7">
		<div class="panel panel-default" style="width:1000px">
		  <div class="panel-heading" align="center"><h4><b>List of all Users</b></h4></div>
		    <table class="table table-striped">
			  <thead>
			    <tr>
			      <th width="130px">First Name</th>
			      <th width="130px">Last name</th>
			      <th>Email Address</th>
			      <th>Gender</th>
			      <th>Age</th>
			      <th>Action</th>
			    </tr>
			  </thead>
			  <tbody>
			    <?php
					while ($res = mysqli_fetch_array($result))
					{
						echo "<tr>";
						echo "<td>".$res['fname']."</td>";
						echo "<td>".$res['lname']."</td>";
						echo "<td>".$res['email']."</td>";
						echo "<td>".$res['gender']."</td>";
						echo "<td>".$res['age']."</td>";
						echo "<td><a style='width:40px' class='btn btn-success' href=\"viewuserprofile.php?userid=$res[userid]\"><span class='glyphicon glyphicon-eye-open'></span></a> | <a style='width:40px' class='btn btn-success' href=\"adminviewcustomers.php?userid=$res[userid]\"onClick=\"return confirm('Are you sure you want to delete customer?')\"><span class='glyphicon glyphicon-trash'></span></a></td>";
						echo '</tr>';
					}
				?>
			  </tbody>
		  </table>
		</div>
	</div>
</div>

</body>
</html>
