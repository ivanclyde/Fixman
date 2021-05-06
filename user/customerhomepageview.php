<?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../includes/config.php');

	$userid = $_SESSION['userid'];


	if(isset($_POST['dis']))
	{
		$dis = $_POST['dis'];
		$displayworks = "SELECT * FROM repairman WHERE (category LIKE '%$dis%' OR address LIKE '%$dis%' OR fname LIKE '%$dis%') AND status='Approved' AND transaction ='Available' AND paymentopt='1'  ORDER BY repairmanid DESC";
		$disworks = mysqli_query($database, $displayworks);
		$rows = mysqli_num_rows($disworks);

		if($rows == 0)
		{
			echo "<script>alert('No Record Found'); window.location.href='customerhomepage.php';</script>";
		}
	} 
	else 
	{
		$displayworks = "SELECT * FROM repairman WHERE status = 'Approved' AND transaction ='Available' AND paymentopt='1' ORDER BY repairmanid DESC";
		$disworks = mysqli_query($database, $displayworks);
	}

	$results = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
	  while ($res = mysqli_fetch_array($results)) 
	  {
	    $fname = $res['fname'];
	    $profilepix = $res['profilepix'];
	  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Hompage</title>
	<meta charset="utf-8">
	<link rel="icon" href="../images/mana.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="../repairman/fullcalendar/lib/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
      rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="user.css">
<style type="text/css">
.card {
	text-align: center;
	transform:translate(0%,0%);
	width:500px !important;
    min-height:auto;
    background:#f0f0f0;
	box-shadow:0 20px 50px rgba(0,0,0,.1);
    border-radius:10px;
    transition:0.5s;
    margin-bottom: 20px;
}
.card:hover {
    box-shadow:5 30px 70px rgba(0,0,0,.2);
    background-color: #cce0ff;
}
.card img {
	margin-top: 10px;
	margin-left: 30px;
	margin-right: 30px;
	margin-bottom: 10px;
	width: 150px;
	height: 150px;
	border-radius: 100px;
}
</style>
</head>
<body>
<?php include('userheader.php');?>

<div>
	<div class="col-sm-12">
		<center>
			<div class="col-md-4">
				<form action="customerhomepageview.php" method="post">
				    <div class="input-group">
				        <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Search for repairman . . ." name="dis" style="margin-top:50px" value="<?php echo isset($_POST['dis']) ? $_POST['dis'] : '' ?>">
				        <div class="input-group-prepend">
						<button class="btn btn-success" type="submit" name="display" style="margin-top:50px"><i class="bi bi-search"></i> Search </button>
				        </div>
				    </div>
				</form>
			</div><br>
		</center>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">

	</div>
	<div class="col-sm-6">
	<center>
	<?php
		while ($diswrk = mysqli_fetch_array($disworks))
		{
			$repairmanid = $diswrk['repairmanid'];
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

			$fees=number_format($diswrk['fee'], 2);

			echo '<a href="viewrepairman.php?repairmanid='.$diswrk['repairmanid'].'" style="color:black;text-decoration:none"><div class="card" style="width: 18rem">';
			echo '<table><tr>';
			echo '<td width="150px"><img class="card-img-top" src="../profilepix/'.$diswrk['profilepix'].'" alt="'.$diswrk['fname'].' '.$diswrk['lname'].'"></td>';
			echo '<td style="text-align:left">';
			echo '<p class="card-text"><h5>'.$diswrk['fname'].' '.$diswrk['lname'].'</h5></p>';
			echo '<p class="card-text" style="margin-top:-15px"><h6>'.$diswrk['category'].'</h6></p>';
			echo '<p style="margin-top:-20px;margin-bottom:30px"><b>Rating : </b>'; if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } echo '</p>';
			echo '<p class="card-text" style="margin-top:-15px"><h6><b>Address : </b>'.$diswrk['address'].'</h6></p>';
			echo '<p class="card-text" style="margin-top:-15px"><h6><b>Experience : </b>'.$diswrk['experience'].'</h6></p>';
			echo '<p class="card-text" style="margin-top:-15px"><h6><b>Fee : </b><p style="color:blue;display:inline">₱ '.$diswrk['fee'].' / day</h6></p>';
			echo '</td>';
			echo '</tr></table>';
			echo '</div></a>';
		}
  	?>
  	</center>
	</div>
	<div class="col-sm-3">

	</div>
</div>

<br>
<?php include('../includes/footer.php'); ?>
</body>
</html>