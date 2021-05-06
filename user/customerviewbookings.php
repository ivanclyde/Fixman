<?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../includes/config.php');

	$userid = $_SESSION['userid'];

	$users = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
	while ($use = mysqli_fetch_array($users)) 
	{
	  $fname = $use['fname'];
	  $profilepix = $use['profilepix'];
	}
                                                 
	$result = mysqli_query($database, "SELECT * FROM booking WHERE userid = '$_SESSION[userid]' AND status = 'Pending' OR status = 'Rescheduled' OR status = 'Approved' OR status = 'Paid' OR status = 'Unpaid' OR status = 'For rating' ORDER BY no ASC");
?>

<!DOCTYPE html>
<html>
<head>
	<title>My Bookings</title>
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
</head>
<body>
<form action="customerhomepageview.php" method="post">
<?php 
  include('userheader.php');
?>
	
<div style="height:500px"><center>
	<div>
		<ul class="nav justify-content-center">
		  <li class="nav-item">
		    <a class="nav-link active" href="customerviewbookings.php" style="color:red;text-decoration:underline">Ongoing</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link">|</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="completedbookings.php">Completed</a>
		  </li>
		</ul>
	</div>
		<table class="table table-striped" style="width:1300px">
			<thead><tr>
				<th>Category</th>
				<th>Name</th>
				<th>Description</th>
				<th>Date of Booking</th>
				<th>Time of Booking</th>
				<th>Fee</th>
				<th>Status</th>
				<th>Options</th>
			</tr></thead>
			<?php 
			while ($row = mysqli_fetch_array($result))
			{
				$repairmanid = $row['repairmanid'];
				$repairman = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
				while ($rep = mysqli_fetch_array($repairman)) 
				{
					echo "<tr bgcolor='white'>";
					echo "<td>".$row['category']."</td>";
					echo "<td>".$rep['fname'], "&nbsp&nbsp" .$rep['lname']."</td>";
					echo "<td>".$row['description']."</td>";
					echo "<td>".$newdateob = date('F d, Y', strtotime($row['dateob']));"</td>";
					echo "<td>".$newtimeob = date('h:i A', strtotime($row['timeob']));"</td>";
					echo "<td> ₱".number_format($row['fee'], 2)."</td>";
					if($row['status'] == 'Pending')
					{
						echo "<td style='background-color:#FFCC00'><b>".$row['status']."</b></td>";
						echo "<td align='center'><a href=\"customerviewbookingdetailsstep1.php?bookingid=$row[bookingid]&repairmanid=$row[repairmanid]\"><i class='bi bi-eye'></i></a></td></tr>";
					}
					if($row['status'] == 'Rescheduled')
					{
						echo "<td style='background-color:#FFCC00'><b>".$row['status']."</b></td>";
						echo "<td align='center'><a href=\"customerviewbookingdetailsstep1.php?bookingid=$row[bookingid]&repairmanid=$row[repairmanid]\"><i class='bi bi-eye'></i></a></td></tr>";
					}
					if($row['status'] == 'Approved')
					{
						echo "<td style='background-color:#00FF00'><b>".$row['status']."</b></td>";
						echo "<td align='center'><a href=\"customerviewbookingdetailsstep1.php?bookingid=$row[bookingid]&repairmanid=$row[repairmanid]\"><i class='bi bi-eye'></i></a></td></tr>";
					}
					if($row['status'] == 'Unpaid')
					{
						echo "<td style='background-color:#00FF00'><b>".$row['status']."</b></td>";
						echo "<td align='center'><a href=\"customerviewbookingdetailsstep2.php?bookingid=$row[bookingid]&repairmanid=$row[repairmanid]&repairmanid=$row[repairmanid]\"><i class='bi bi-eye'></i></a></td></tr>";
					}
					if($row['status'] == 'Paid')
					{
						echo "<td style='background-color:#00FF00'><b>".$row['status']."</b></td>";
						echo "<td align='center'><a href=\"customerviewbookingdetailsstep3.php?bookingid=$row[bookingid]&repairmanid=$row[repairmanid]\"> For Rating</a></td></tr>";
					}
					if($row['status'] == 'For rating')
					{
						echo "<td style='background-color:#00FF00'><b>".$row['status']."</b></td>";
						echo "<td align='center'><a href=\"customerviewbookingdetailsstep3.php?bookingid=$row[bookingid]&repairmanid=$row[repairmanid]\"> For Rating</a></td></tr>";
					}
				}
			}
			?>
		</table>
</center></div>

<br>
<p style="color:red;margin-left:100px;font-size:1.1em">NOTE: Once booking is Approved, you cannot reschedule anymore. Book repairman ahead of time.</p>

<?php include('../includes/footer.php'); ?>
</body>
</html>