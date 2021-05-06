<?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../includes/config.php');
  
	$userid = $_SESSION['userid'];
	$bookingid = $_GET['bookingid'];
  $repairmanid = $_GET['repairmanid'];
  if (empty($_GET['notifid'])) {}
  else
  {
    $notifid = $_GET['notifid'];
    mysqli_query($database, "UPDATE notification SET status = '1' WHERE notifid='$notifid'");
  }

  $display = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
  while ($dis = mysqli_fetch_array($display)) 
  {
    $rfname = $dis['fname'];
    $rlname = $dis['lname'];
  }

  $result = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
  while ($row = mysqli_fetch_array($result)) 
  {
    $fname = $row['fname'];
    $clname = $row['lname'];
    $profilepix = $row['profilepix'];
  }

  $results = mysqli_query($database, "SELECT * FROM booking WHERE bookingid = '$bookingid'");
  while ($res = mysqli_fetch_array($results))
  {
    $category = $res['category'];
    $fee = $res['fee'];
    $totalfee = $res['totalfee'];
    $newdateob = date('F d, Y', strtotime($res['dateob']));
    $newendob = date('F d, Y', strtotime($res['endob']));
    $status = $res['status'];
  }

  $mod = mysqli_query($database, "SELECT * FROM moodofpayment WHERE repairmanid = '$repairmanid'");
  while ($mods = mysqli_fetch_array($mod))
  {
    $bank = $mods['bank'];
    $bankno = $mods['bankno'];
    $name = $mods['name'];
    $paymentapp = $mods['paymentapp'];
    $paymentappname = $mods['paymentappname'];
    $paymentappnumber = $mods['paymentappnumber'];
    $paymentappqrcode = $mods['paymentappqrcode'];
  }

    $add = "1";
    $date1 = date_create($newdateob);
    $date2 = date_create($newendob);
    $days = date_diff($date1,$date2);
    $totaldays = (int)$days->format('%d') + (int)$add;
    $totalfees = (int)$totaldays * (int)$fee;
?>

<!DOCTYPE html>
<html>
<head>
  	<title>View Bookings Details</title>
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
  <style>
  	.payopt {
      border-radius: 10px;
  	}
  	.payopt td {
  		padding: 5px;
  	}
    .table>tbody>tr>td,
	  .table>tbody>tr>th {
  	  border-top: none;
  	  padding: 5px !important;
	  }
  </style>
</head>
<body>	
<?php include('userheader.php')?>

<a href="customerviewbookings.php"><button class="btn btn-light"><i class="bi bi-caret-left"></i>Back</button></a>

<div class="container-fluid text-center">
    <center><table style="border:0px;border-radius:25px;background-color:#59E817;">
        <thead><tr>
          <th class="steps"><i class="bi bi-calendar-range"></i> Booking Details </th>
          <th class="steps" style="background-color:lightgreen"><i class="bi bi-credit-card"></i> Payment Options</th>
          <th class="steps"><i class="bi bi-star-fill"></i> Ratings and Feedback</th>
        </tr></thead>
      </table></center>
      <br>
  <div align="left" style="background-color:#F7FAFF;width:900px;border-radius:10px;margin-left:210px">
    <center>
      <label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-credit-card"></i> Payment Options</h2></b></label>
      <div class="col-sm-12" style="text-align:left;background-color:#E5E4E2;border-radius:10px;width:400px;padding-bottom:10px">
        <?php
          if(mysqli_num_rows($mod) == 1)
          { ?>
            <label style=" font-size:1.5em"><b>Bank Account</b></label><br>
            <label><b>Bank </b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <?php echo $bank?></label>
            <label><b>Full Name </b>&emsp;&emsp;&emsp;&emsp;&nbsp&nbsp <?php echo $name?></label>
            <label><b>Bank Number </b>&emsp;&emsp;&nbsp&nbsp&nbsp <?php echo $bankno?></label>
            <label style=" font-size:1.5em"><b>Online Payment</b></label>
            <label><b>Payment App </b>&emsp;&emsp;&nbsp&nbsp&nbsp <?php echo $paymentapp?></label>
            <label><b>Full Name </b>&emsp;&emsp;&emsp;&emsp;&nbsp <?php echo $paymentappname?></label>
            <label><b>Number </b>&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp <?php echo $paymentappnumber?></label>
            <label><b>QR Code </b>&emsp;&emsp;&emsp;&emsp;&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-info" data-toggle="modal" data-target="#qrcode">View</button></label> 
            <h6><b>Status </b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp<?php echo '<font style="color:blue">'.$status; echo'<font style="color:black">'; ?></h6><br>
            <p align="center"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#receipt">View E-Receipt</button></p>
    <?php } ?>
      </div><br>
    </center>
  </div>
<!-- Modal for Receipt-->
<div id="receipt" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" align="center">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp<b>E-Receipt</b></h4>
      </div>
      <div class="modal-body">
        <center><table class="payopt" style="background-color:#E5E4E2;border-radius: 10px;">
          <tr>
            <td><b>Client Name</b></td>
            <td></td>
            <td><?php echo $fname; echo '&nbsp&nbsp'; echo $clname;?></td>
          </tr>
          <tr>
            <td><b><?php echo $category?></b></td>
            <td></td>
            <td><?php echo $rfname; echo '&nbsp&nbsp'; echo $rlname;?></td>
          </tr>
          <tr><td colspan="3"><hr></td></tr>
          <tr>
            <td>Start of Repair</td>
            <td align="center"> : </td>
            <td><?php echo $newdateob?></td>
          </tr>
          <tr>
            <td>End of Repair</td>
            <td align="center"> : </td>
            <td><?php echo $newendob?></td>
          </tr>
          <tr>
            <td>No. of Days</td>
            <td align="center"> : </td>
            <td><?php echo $totaldays?> days</td>
          </tr>
          <tr>
            <td>Fee</td>
            <td align="center"> : </td>
            <td> ₱ <?php echo $fee?></td>
          </tr>
          <tr><td colspan="3"><hr></td></tr>
          <tr>
            <td></td>
            <td align="center">Total Fee : </td>
            <td> ₱ <?php echo number_format($totalfees, 2)?></td>
          </tr>
        </table></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--- Modal for QR Code -->
<div id="qrcode" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" align="center">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Scan to Pay</b></h4>
      </div>
      <div class="modal-body">
        <center><img src="../qrcodes/<?php echo $paymentappqrcode?>" width="300px" height="300px"></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>

<br>
<?php include('../includes/footer.php'); ?>
</body>
</html>