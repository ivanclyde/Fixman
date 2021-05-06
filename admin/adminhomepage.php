<?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../includes/config.php');

	$badge = mysqli_query($database, "SELECT * FROM repairman WHERE status='Pending'");
	$count = mysqli_num_rows($badge);
	$totalrepairman = mysqli_query($database, "SELECT * FROM repairman WHERE status='Approved'");
	$repairman = mysqli_num_rows($totalrepairman);
	$totalusers = mysqli_query($database, "SELECT * FROM users WHERE user_type='Customer'");
	$users = mysqli_num_rows($totalusers);
	$totalmechanic = mysqli_query($database, "SELECT * FROM repairman WHERE category='Mechanic' AND status = 'Approved'");
	$mechanic = mysqli_num_rows($totalmechanic);
	$totalcarpenter = mysqli_query($database, "SELECT * FROM repairman WHERE category='Carpenter'  AND status = 'Approved'");
	$carpenter = mysqli_num_rows($totalcarpenter);
	$totalelectrician = mysqli_query($database, "SELECT * FROM repairman WHERE category='Electrician' AND status = 'Approved'");
	$electrician = mysqli_num_rows($totalelectrician);
	$totalplumber = mysqli_query($database, "SELECT * FROM repairman WHERE category='Plumber' AND status = 'Approved'");
	$plumber = mysqli_num_rows($totalplumber);
	$totaltechnician = mysqli_query($database, "SELECT * FROM repairman WHERE category='Technician' AND status = 'Approved'");
	$technician = mysqli_num_rows($totaltechnician);

?>


<!DOCTYPE html>
<html>
<head>
	<title>Admin Hompage</title>
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
		<a class="btn btn-warning" href="adminhomepage.php">Overview</a><br>
		<a class="btn btn-info" href="adminviewusers.php">View All Users</a><br>
		<a class="btn btn-info" href="adminviewrepairman.php">View All Repairman</a><br>
		<a class="btn btn-info" href="adminviewapplications.php">View Repairman Applications <span class="badge badge-light" style="background-color:red"><?php if(mysqli_num_rows($badge) != 0){echo $count;}else{}?></span></a>
	</div>
	<div class="col-md-7">
		<div class="col-sm-3" style="margin-right:50px">
			<div class="panel panel-primary" style="width:200px;">
			  <div class="panel-heading" align="center"><h4><b>Total Repairman</b></h4></div>
			  	<div class="panel-body" style="text-align:center;font-size:3em">
			    	<span><strong><?php echo $repairman ?></strong></span>
			    </div>
			</div>
		</div>
		<div class="col-sm-3" style="margin-right:100px">
			<div class="panel panel-primary" style="width:200px;">
			  <div class="panel-heading" align="center"><h4><b>Total Users</b></h4></div>
			  	<div class="panel-body" style="text-align:center;font-size:3em">
			    	<span><strong><?php echo $users ?></strong></span>
			    </div>
			</div>
		</div>
		<div class="col-sm-3" style="margin-right:50px">
			<div class="panel panel-primary" style="width:200px">
			  <div class="panel-heading" align="center"><h4><b>Total Mechanic</b></h4></div>
			  	<div class="panel-body" style="text-align:center;font-size:3em">
			    	<span><strong><?php echo $mechanic ?></strong></span>
			    </div>
			</div>
		</div>
		<div class="col-sm-3" style="margin-right:50px">
			<div class="panel panel-primary" style="width:200px">
			  <div class="panel-heading" align="center"><h4><b>Total Carpenter</b></h4></div>
			  	<div class="panel-body" style="text-align:center;font-size:3em">
			    	<span><strong><?php echo $carpenter ?></strong></span>
			    </div>
			</div>
		</div>
		<div class="col-sm-3" style="margin-right:50px">
			<div class="panel panel-primary" style="width:200px">
			  <div class="panel-heading" align="center"><h4><b>Total Electrician</b></h4></div>
			  	<div class="panel-body" style="text-align:center;font-size:3em">
			    	<span><strong><?php echo $electrician ?></strong></span>
			    </div>
			</div>
		</div>
		<div class="col-sm-3" style="margin-right:50px">
			<div class="panel panel-primary" style="width:200px">
			  <div class="panel-heading" align="center"><h4><b>Total Plumber</b></h4></div>
			  	<div class="panel-body" style="text-align:center;font-size:3em">
			    	<span><strong><?php echo $plumber ?></strong></span>
			    </div>
			</div>
		</div>
		<div class="col-sm-3" style="margin-right:50px">
			<div class="panel panel-primary" style="width:200px">
			  <div class="panel-heading" align="center"><h4><b>Total Technician</b></h4></div>
			  	<div class="panel-body" style="text-align:center;font-size:3em">
			    	<span><strong><?php echo $technician ?></strong></span>
			    </div>
			</div>
		</div>
	</div>
</div>

</body>
</html>
