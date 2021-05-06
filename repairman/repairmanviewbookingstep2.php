<?php
	session_start();

	if (!isset($_SESSION['repairmanid'])) 
	{
		header('Location: index.php');
	}

	include('../includes/config.php');

	$repairmanid = $_SESSION['repairmanid'];
	$bookingid = $_GET['bookingid'];
	$userid = $_GET['userid'];

	$results = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
	while ($rows = mysqli_fetch_array($results)) 
	{
	  $email = $rows['email'];
	}

  	$result = mysqli_query($database, "SELECT * FROM booking WHERE bookingid = '$bookingid'");
 	while ($row = mysqli_fetch_array($result)) 
  	{
	    $status = $row['status'];
	    $fee = $row['fee'];
	    $category = $row['category'];
	    $dateob = $row['dateob'];
	    $endob = $row['endob'];
	    $newtimeob = date('h:i A', strtotime($row['timeob']));
	    $newdateob = date('F d, Y', strtotime($row['dateob']));
	    $newendob = date('F d, Y', strtotime($row['endob']));
  	}
  	$display = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
  	while ($rows = mysqli_fetch_array($display)) 
	{
	    $cfname = $rows['fname'];
	    $clname = $rows['lname'];
	    $address = $rows['address'];
	    $contactno = $rows['contactno'];
	}
  
  	if (isset($_POST['setdate']))
	  {
	    $endob = mysqli_real_escape_string($database, $_POST['endob']);
	    $endob = date('Y-m-d', strtotime($endob));

	    $notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
	    $notifto = mysqli_real_escape_string($database,$userid);
	    $notiffrom = mysqli_real_escape_string($database,$_SESSION['repairmanid']);
	    $content = 'You still have unpaid booking for '.$category.'.';
	    $link = 'http://localhost/fixman/user/customerviewbookingdetailsstep2.php?bookingid='.$bookingid.'&repairmanid='.$repairmanid.'&notifid='.$notifid;

	    if ($endob < $dateob)
	    {
	      echo "<script>alert('You cannot choose date behind the date of booking.');window.location.href='repairmanviewbookingstep2.php?bookingid=$_GET[bookingid]&userid=$_GET[userid]';</script>";
	    }
	    else
	    {
	      	mysqli_query($database, "UPDATE booking SET status='Unpaid', endob='$endob' WHERE bookingid='$bookingid'");
	      	mysqli_query($database, "INSERT INTO notification(notifid, notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
	      	echo "<script>alert('End of booking date has been set');window.location.href='repairmanviewbookingstep2.php?bookingid=$_GET[bookingid]&userid=$_GET[userid]';</script>";
	    }
	  }
	  $sqlendob = mysqli_query($database, "SELECT * FROM booking WHERE endob = '$endob' AND status = 'Approved'");
	  $checkendob = mysqli_num_rows($sqlendob);

	  $results = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
	  while ($res = mysqli_fetch_array($results)) 
	  {
	    $fname = $res['fname'];
	    $rlname = $res['lname'];
	    $profilepix = $res['profilepix'];
	  }

	  if (isset($_POST['paid']))
	  {
	  	$add = "1";
	    $date1 = date_create($endob);
	    $date2 = date_create($dateob);
	    $days = date_diff($date1,$date2);
	    $totaldays = (int)$days->format("%R%a") + (int)$add;
	    $totalfee = (int)$totaldays * (int)$fee;

	 	$date = date(" F j, Y ");

	    $totalfee = mysqli_real_escape_string($database, $_POST['totalfee']);
	    $totaldays = mysqli_real_escape_string($database, $_POST['totaldays']);
	    $notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
	    $notifto = mysqli_real_escape_string($database,$userid);
	    $notiffrom = mysqli_real_escape_string($database,$_SESSION['repairmanid']);
	    $content = 'You can rate and give feedback to your '.$category.'.';
	    $link = 'http://localhost/fixman/user/customerviewbookingdetailsstep3.php?bookingid='.$bookingid.'&repairmanid='.$repairmanid.'&notifid='.$notifid;

	    $to = $email;
		$subject = "E-Receipt";
		$message = '<b><h3>E-Receipt</h3></b> <br>
				<table style="background-color:#E5E4E2;border-radius:10px;font-size:1em">
	                    <tr>
	                      <td><b>Client</b></td>
	                      <td></td>
	                      <td>'.$cfname.' '.$clname.'</td>
	                    </tr>
	                    <tr>
	                      <td><b>'.$category.'</b></td>
	                      <td></td>
	                      <td>'.$fname.' '.$rlname.'</td>
	                    </tr>
	                    <tr>
	                      <td><b>Date</b></td>
	                      <td></td>
	                      <td>'.$date.'</td>
	                    </tr>
	                    <tr><td colspan="3"><hr style="margin-top:0px;margin-bottom:0px;"></td></tr>
	                    <tr>
	                      <td>Start of Booking</td>
	                      <td align="center"> : </td>
	                      <td>'.$newdateob.'</td>
	                    </tr>
	                    <tr>
	                      <td>End of Booking</td>
	                      <td align="center"> : </td>
	                      <td>'.$newendob.'</td>
	                    </tr>
	                    <tr>
	                      <td>No. of Days</td>
	                      <td align="center"> : </td>
	                      <td>'.$totaldays.' days</td>
	                    </tr>
	                    <tr>
	                      <td>Fee</td>
	                      <td align="center"> : </td>
	                      <td> ₱ '.$fee.'</td>
	                    </tr>
	                    <tr><td colspan="3"><hr></td></tr>
	                    <tr>
	                      <td></td>
	                      <td align="center">Total Fee : </td>
	                      <td> ₱ '.number_format($totalfee, 2).'</td>
	                    </tr>
	                  </table><br><p>You can rate and give feedback to your '.$category.'</p>';
		$headers = "From: FIX-MAN TEAM \r\n";
		$headers .= "MINE-Version: 1.0" ."\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		mail($to, $subject, $message, $headers);

		mysqli_query($database, "INSERT INTO notification(notifid, notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
	    mysqli_query($database, "UPDATE booking SET status='Paid', totalfee = '$totalfee', totaldays = '$totaldays' WHERE bookingid='$bookingid'");
	    echo "<script>alert('Payment Confirmed');window.location.href='repairmanviewbookings.php?bookingid=$_GET[bookingid]';</script>";
	  }

	  $add = "1";
	  $date1 = date_create($dateob);
	  $date2 = date_create($endob);
	  $days = date_diff($date1,$date2);
	  $totaldays = (int)$days->format("%R%a") + (int)$add;
	  $totalfee = (int)$totaldays * (int)$fee;
?>

<!DOCTYPE html>
<html>
<head>
	<title>View Bookings Details</title>
	<meta charset="utf-8">
	<link rel="icon" href="../images/mana.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="fullcalendar/lib/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
      rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="repairman.css">
  <style>
  	.steps th {
  		padding: 5px;
  		text-align: center;
  		width: 300px;
  		height: 50px;
  		border-radius: 50px;
  		font-size: 20px;
  	}
  	.receipt td {
  		padding: 5px;
  	}
    .btn-default {
      	width: 100px;
    }
  </style>
</head>
<body>	
<?php 
  include('repairmanheader.php')
?>

<a href="repairmanviewbookings.php"><button class="btn btn-light"><i class="bi bi-caret-left"></i>Back</button></a>

<div class="container-fluid text-center">
	<div class="row content">
		<div class="col-lg-12" align="left">
		<center><table class="steps" border="0" style="background-color:#59E817;border-radius:25px">
    		<thead><tr>
    			<th><i class="bi bi-calendar-range"></i> Booking Details </th>
    			<th style="background-color:lightgreen"><i class="bi bi-receipt"></i> Receipt</th>
    			<th><i class="bi bi-card-list"></i> Summary</th>
    		</tr></thead>
    	</table></center><br>
    	</div>
   <div align="left" style="background-color:#F7FAFF;width:900px;border-radius:10px;margin-left:225px">
   	<center>
   		<label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-receipt"></i> Receipt</h2></b></label>
   			<table class="receipt" style="background-color:#E5E4E2; border-radius:10px;">
	          <form action="#.php" method="post">
	          <input type="hidden" name="totalfee" value=<?php echo $totalfee?>>
	          <input type="hidden" name="totaldays" value=<?php echo $totaldays?>>
	          <tr>
	            <td><b><?php echo$category?></b></td>
	            <td></td>
	            <td><?php echo $fname; echo str_repeat('&nbsp;', 2); echo $rlname?></td>
	          </tr>
	          <tr>
	            <td><b>Client Name</b></td>
	            <td></td>
	            <td><?php echo $cfname; echo str_repeat('&nbsp;', 2); echo $clname?></td>
	          </tr>
	          <tr>
				<tr><td colspan="3"><hr></td></tr>
	          </tr>
	          <tr>
	            <td><b>Start of Repair</b></td>
	            <td></td>
	            <td><?php echo $newdateob;?></td>
	          </tr>
	          <tr>
	            <td><b>Time of Repair</b></td>
	            <td></td>
	            <td><?php echo $newtimeob;?></td>
	          </tr> 
	          <?php
	          if($checkendob == '1') //if walay sud
	            {
	              echo '<tr>';
	              echo '<td><b>End of Repair</b></td>';
	              echo '<td></td>';
	              echo '<td><input class="form-control" type="date" name="endob"></td>';
	              echo '</tr>';
	            }
	          else
	            {
	                echo '<tr>';
	                echo '<td><b>End of Repair</b></td>';
	                echo '<td></td>';
	                echo '<td>'.$newendob;'</td>';
	                echo '</tr>';
	            }
	          ?>
	          <tr>
	            <td><b>Fee</b></td>
	            <td></td>
	            <td>₱ <?php echo $fee?></td>
	          </tr>
	          <?php
	          if($checkendob == '1') //if walay sud
	            {
	           	  echo '<tr>';
	              echo '<td><b>Status</b></td>';
	              echo '<td></td>'; ?>
	              <td><?php if($status == 'Approved'){echo '<font style="color:green">'.$status;}else{echo '<font style="color:red">'.$status;}?></td>
	        <?php echo '</tr>';
	              echo '<tr>';
	              echo '<td></td><td></td>';
	              echo '<td colspan="5" align="center"><input class="btn btn-success" type="submit" name="setdate" value="Confirm"></td>';
	              echo '</tr>';
	            }
	          else
	            {
	                echo '<tr>';
	                echo '<td><b>No. of Days</b></td>';
	                echo '<td></td>';
	                echo '<td>'.$totaldays.' days</td>';
	                echo '</tr>';
	                echo '<tr>';
	                echo '<td><b>Total Fee</b></td>';
	                echo '<td></td>';
	                echo '<td> ₱ '.number_format($totalfee, 2);'</td>';
	                echo '</tr>';
	                echo '<tr>';
	                echo '<td><b>Status</b></td>';
	                echo '<td></td>'; ?>
	                <td><?php if($status == 'Approved'){echo '<font style="color:green">'.$status;}else{echo '<font style="color:red">'.$status;}?></td>
	          <?php echo '</tr>';
	                echo '<tr><td colspan="3"><hr></td></tr>';
	                if($status != 'Paid')
	                {
		                echo '<tr>';
		                echo '<td colspan="5" align="center"><input style="width:100px" class="btn btn-success" type="submit" name="paid" value="Paid" onclick="return confirm("Payment Confirm?")"></td>';
		                echo '</tr>';
	                }
	            }
	          ?>
	          </form>
	        </table>
   	</center><br>
   </div>
  </div>
</div>
<br>
<?php include('../includes/footer.php') ?>
</body>
</html>