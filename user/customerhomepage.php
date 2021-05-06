<?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	date_default_timezone_set('Asia/Manila');
	include('../includes/config.php');

	$userid = $_SESSION['userid'];

	$results = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
	while ($res = mysqli_fetch_array($results)) 
	{
	  $fname = $res['fname'];
	  $profilepix = $res['profilepix'];
	}

	$carpenter = mysqli_query($database, "SELECT repairmanid, profilepix, fname, lname, category FROM repairman WHERE transaction = 'Available' AND paymentopt = '1' AND category = 'Carpenter' ORDER BY RAND () LIMIT 1");
	$plumber = mysqli_query($database, "SELECT repairmanid, profilepix, fname, lname, category FROM repairman WHERE transaction = 'Available' AND paymentopt = '1' AND category = 'Plumber' ORDER BY RAND () LIMIT 1");
	$electrician = mysqli_query($database, "SELECT repairmanid, profilepix, fname, lname, category FROM repairman WHERE transaction = 'Available' AND paymentopt = '1' AND category = 'Electrician' ORDER BY RAND () LIMIT 1");
	$mechanic = mysqli_query($database, "SELECT repairmanid, profilepix, fname, lname, category FROM repairman WHERE transaction = 'Available' AND paymentopt = '1' AND category = 'Mechanic' ORDER BY RAND () LIMIT 1");
	$technician = mysqli_query($database, "SELECT repairmanid, profilepix, fname, lname, category FROM repairman WHERE transaction = 'Available' AND paymentopt = '1' AND category = 'Technician' ORDER BY RAND () LIMIT 1");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Hompage</title>
	<link rel="icon" href="../images/mana.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="../repairman/fullcalendar/lib/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
      rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="user.css">
<style type="text/css">
.repairman {
	width: 270px;
}
.display-repairman img{
	margin-top: 10px !important;
	height: 150px;
	width: 150px;
	border-radius: 100px;
    display: block;
    margin: 0 auto;
}
.card {
	text-align: center;
	left:9%;
	transform:translate(0%,0%);
	width:250px !important;
    min-height:auto;
    background:#fff;
	box-shadow:0 20px 50px rgba(0,0,0,.1);
    border-radius:10px;
    transition:0.5s;
}
.card:hover {
    box-shadow:5 30px 70px rgba(0,0,0,.2);
    background-color: #cce0ff;
}
</style>
</head>
<body>
<?php include('userheader.php')?>
<div  style="background-image:url('../images/userhomepage.png');height:500px">
	<div class="col-sm-12">
		<center>
			<div class="col-md-4">
				<form action="customerhomepageview.php" method="post">
				    <div class="input-group">
				        <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Search for repairman . . ." name="dis" style="margin-top:50px">
				        <div class="input-group-prepend">
						<button class="btn btn-success" type="submit" name="display" style="margin-top:50px"><i class="bi bi-search"></i> Search </button>
				        </div>
				    </div>
				</form>
			</div><br>
		</center>
	</div>
</div>
<br><br>
<div style="margin-bottom:3%;text-align:center"><h1><p>Suggested Repairman</p></h1></div>
<div class="row display-repairman">
	<div class="repairman">
		<?php 
			while ($car = mysqli_fetch_array($carpenter))
			{
				$repairmanid = $car['repairmanid'];
				$rating = mysqli_query($database, "SELECT sum(rate) AS rate FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				$rates =mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				while($rat = mysqli_fetch_array($rating))
				{
				  $number = mysqli_num_rows($rates);
				  $rate = $rat['rate'];
				  if($rate == 0)
				  { 
				    $totalrate = '0.0';
				  }
				  else
				  {
				    $totalrate = $rate / $number;
				  }
				}

				echo '<a href="viewrepairman.php?repairmanid='.$car['repairmanid'].'" style="color:black;text-decoration:none"><div class="card" style="width: 18rem">';
				echo '<img class="card-img-top" src="'.$car['profilepix'].'" alt="'.$car['fname'].' '.$car['lname'].'">';
				echo '<div class="car-body">';
				echo '<p class="card-text"><h5>'.$car['fname'].' '.$car['lname'].'</h5></p>';
				echo '<p class="card-text" style="margin-top:-15px"><h6>'.$car['category'].'</h6></p>';
				echo '<p style="margin-top:-10px"><b>Rating : </b>'; if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } echo '</p>';
				echo '</div>';
				echo '</div></a>';
			}
		?>
	</div>
	<div class="repairman">
		<?php
			while ($plu = mysqli_fetch_array($plumber))
			{
				$repairmanid = $plu['repairmanid'];
				$rating = mysqli_query($database, "SELECT sum(rate) AS rate FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				$rates =mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				while($rat = mysqli_fetch_array($rating))
				{
				  $number = mysqli_num_rows($rates);
				  $rate = $rat['rate'];
				  if($rate == 0)
				  { 
				    $totalrate = '0.0';
				  }
				  else
				  {
				    $totalrate = $rate / $number;
				  }
				}

				echo '<a href="viewrepairman.php?repairmanid='.$plu['repairmanid'].'" style="color:black;text-decoration:none"><div class="card" style="width: 18rem">';
				echo '<img class="card-img-top" src="../profilepix/'.$plu['profilepix'].'" alt="'.$plu['fname'].' '.$plu['lname'].'">';
				echo '<div class="car-body">';
				echo '<p class="card-text"><h5>'.$plu['fname'].' '.$plu['lname'].'</h5></p>';
				echo '<p class="card-text" style="margin-top:-15px"><h6>'.$plu['category'].'</h6></p>';
				echo '<p style="margin-top:-10px"><b>Rating : </b>'; if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } echo '</p>';
				echo '</div>';
				echo '</div></a>';
			}
		?>
	</div>
	<div class="repairman">
		<?php
			while ($ele = mysqli_fetch_array($electrician))
			{
				$repairmanid = $ele['repairmanid'];
				$rating = mysqli_query($database, "SELECT sum(rate) AS rate FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				$rates =mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				while($rat = mysqli_fetch_array($rating))
				{
				  $number = mysqli_num_rows($rates);
				  $rate = $rat['rate'];
				  if($rate == 0)
				  { 
				    $totalrate = '0.0';
				  }
				  else
				  {
				    $totalrate = $rate / $number;
				  }
				}

				echo '<a href="viewrepairman.php?repairmanid='.$ele['repairmanid'].'" style="color:black;text-decoration:none"><div class="card" style="width: 18rem">';
				echo '<img class="card-img-top" src="../profilepix/'.$ele['profilepix'].'" alt="'.$ele['fname'].' '.$ele['lname'].'">';
				echo '<div class="car-body">';
				echo '<p class="card-text"><h5>'.$ele['fname'].' '.$ele['lname'].'</h5></p>';
				echo '<p class="card-text" style="margin-top:-15px"><h6>'.$ele['category'].'</h6></p>';
				echo '<p style="margin-top:-10px"><b>Rating : </b>'; if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } echo '</p>';
				echo '</div>';
				echo '</div></a>';
			}
		?>
	</div>
	<div class="repairman">
		<?php
			while ($tec = mysqli_fetch_array($technician))
			{
				$repairmanid = $tec['repairmanid'];
				$rating = mysqli_query($database, "SELECT sum(rate) AS rate FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				$rates =mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				while($rat = mysqli_fetch_array($rating))
				{
				  $number = mysqli_num_rows($rates);
				  $rate = $rat['rate'];
				  if($rate == 0)
				  { 
				    $totalrate = '0.0';
				  }
				  else
				  {
				    $totalrate = $rate / $number;
				  }
				}

				echo '<a href="viewrepairman.php?repairmanid='.$tec['repairmanid'].'" style="color:black;text-decoration:none"><div class="card" style="width: 18rem">';
				echo '<img class="card-img-top" src="../profilepix/'.$tec['profilepix'].'" alt="'.$tec['fname'].' '.$tec['lname'].'">';
				echo '<div class="car-body">';
				echo '<p class="card-text"><h5>'.$tec['fname'].' '.$tec['lname'].'</h5></p>';
				echo '<p class="card-text" style="margin-top:-15px"><h6>'.$tec['category'].'</h6></p>';
				echo '<p style="margin-top:-10px"><b>Rating : </b>'; if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } echo '</p>';
				echo '</div>';
				echo '</div></a>';
			}
		?>
	</div>
	<div class="repairman carpenter">
		<?php
			while ($mec = mysqli_fetch_array($mechanic))
			{
				$repairmanid = $mec['repairmanid'];
				$rating = mysqli_query($database, "SELECT sum(rate) AS rate FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				$rates =mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
				while($rat = mysqli_fetch_array($rating))
				{
				  $number = mysqli_num_rows($rates);
				  $rate = $rat['rate'];
				  if($rate == 0)
				  { 
				    $totalrate = '0.0';
				  }
				  else
				  {
				    $totalrate = $rate / $number;
				  }
				}

				echo '<a href="viewrepairman.php?repairmanid='.$mec['repairmanid'].'" style="color:black;text-decoration:none"><div class="card" style="width: 18rem">';
				echo '<img class="card-img-top" src="../profilepix/'.$mec['profilepix'].'" alt="'.$mec['fname'].' '.$mec['lname'].'">';
				echo '<div class="car-body">';
				echo '<p class="card-text"><h5>'.$mec['fname'].' '.$mec['lname'].'</h5></p>';
				echo '<p class="card-text" style="margin-top:-15px"><h6>'.$mec['category'].'</h6></p>';
				echo '<p style="margin-top:-10px"><b>Rating : </b>'; if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } echo '</p>';
				echo '</div>';
				echo '</div></a>';
			}
		?>
	</div>
</div>

<br><br>
<?php include('../includes/footer.php'); ?>
</body>
</html>