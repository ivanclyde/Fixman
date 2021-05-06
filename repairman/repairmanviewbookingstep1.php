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

  if (empty($_GET['notifid'])) {}
  else
  {
    $notifid = $_GET['notifid'];
    mysqli_query($database, "UPDATE notification SET status = '1' WHERE notifid='$notifid'");
  }

  $result = mysqli_query($database, "SELECT * FROM booking WHERE bookingid = '$bookingid'");
  while ($row = mysqli_fetch_array($result)) 
  {
    $description = $row['description'];
    $dateob = $row['dateob'];
    $newdateob = date('F d, Y', strtotime($row['dateob']));
    $newtimeob = date('h:i A', strtotime($row['timeob']));
    $newtimebooked = date('F d, Y h:i A', strtotime($row['timebooked']));
    $fee = $row['fee'];
    $status = $row['status'];
    $category = $row['category'];
    $reason = $row['reason'];
  }

  $display = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
  while ($rows = mysqli_fetch_array($display)) 
  {
    $cfname = $rows['fname'];
    $clname = $rows['lname'];
    $address = $rows['address'];
    $contactno = $rows['contactno'];
  }
  
  if (isset($_POST['accept']))
  {
    $start = $dateob;
    $end = $dateob;
    $title = $newtimeob;
    $title2 = $cfname.' '.$clname;
    $notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
    $notifto = mysqli_real_escape_string($database,$userid);
    $notiffrom = mysqli_real_escape_string($database,$_SESSION['repairmanid']);
    $content = 'Your booking for '.$category.' has been approved';
    $link = 'http://localhost/fixman/user/customerviewbookingdetailsstep1.php?bookingid='.$bookingid.'&repairmanid='.$repairmanid.'&notifid='.$notifid;

    $sqlcheck = mysqli_query($database, "SELECT * FROM booking WHERE repairmanid = '$repairmanid' AND status = 'Approved' OR status = 'Unpaid' OR status='Paid'");
    $check = mysqli_num_rows($sqlcheck);
    if($check == 1)
    {
      echo "<script>alert('You still have unfinish bookings!');window.location.href='repairmanviewbookingstep1.php?bookingid=$_GET[bookingid]&userid=$_GET[userid]';</script>";
    }
    else
    {
      mysqli_query($database, "INSERT INTO calendar (repairmanid, bookingid, title, start, end) VALUES ('$repairmanid','$bookingid','$title','$start','$end')");
      mysqli_query($database, "INSERT INTO calendar (repairmanid, bookingid, title, start, end) VALUES ('$repairmanid','$bookingid','$title2','$start','$end')");
      mysqli_query($database, "INSERT INTO notification(notifid, notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
      mysqli_query($database, "UPDATE booking SET status='Approved' WHERE bookingid='$bookingid'");
      mysqli_query($database, "UPDATE repairman SET transaction='On-Book' WHERE repairmanid='$repairmanid'");
      echo "<script>alert('Booking Approved');window.location.href='repairmanviewbookingstep2.php?bookingid=$_GET[bookingid]&userid=$_GET[userid]';</script>";
    }
  }

  if (isset($_POST['decline']))
  {
    $reason = mysqli_real_escape_string($database, $_POST['reason']);

    $notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
    $notifto = mysqli_real_escape_string($database,$userid);
    $notiffrom = mysqli_real_escape_string($database,$_SESSION['repairmanid']);
    $content = 'Your booking for '.$category.' has been decliend';
    $link = 'http://localhost/fixman/user/customerviewbookingdetailsstep1.php?bookingid='.$bookingid.'&repairmanid='.$repairmanid.'&notifid='.$notifid;

    mysqli_query($database, "INSERT INTO notification(notifid, notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
    mysqli_query($database, "UPDATE booking SET status='Declined', reason = '$reason' WHERE bookingid='$bookingid'");

    echo "<script>alert('Booking Declined!');window.location.href='repairmanviewbookings.php?bookingid=$_GET[bookingid]';</script>";
  }

  $results = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
  while ($res = mysqli_fetch_array($results)) 
  {
    $fname = $res['fname'];
    $profilepix = $res['profilepix'];
  }
?>

<!DOCTYPE html>
<html>
<head>
	  <title>Bookings Details</title>
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
  	.details td {
  		padding: 5px;
  	}
    .form-control {
      width:250px !important;
    }
  </style>
</head>
<body>	
<?php include('repairmanheader.php') ?>

<a href="repairmanviewbookings.php"><button class="btn btn-light"><i class="bi bi-caret-left"></i>Back</button></a>

<div class="container-fluid">
  <div class="row content">
    <div class="col-lg-12" align="left">
      <center><table class="steps" border="0" style="background-color:#59E817;border-radius:25px">
        <thead><tr>
          <th style="background-color:lightgreen"><i class="bi bi-calendar-range"></i> Booking Details </th>
          <th><i class="bi bi-receipt"></i> Receipt</th>
          <th><i class="bi bi-card-list"></i> Summary</th>
        </tr></thead>
      </table></center><br>
    </div>
  <div align="left" style="background-color:#F7FAFF;width:900px;border-radius:10px;margin-left:225px">
    <center>
      <label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-calendar-range"></i> Booking Details</h2></b></label>
        <table class="details" style="background-color:#E5E4E2;border-radius:10px;">
          <tr>
            <td><b>Time Booked</b></td>
            <td> : </td>
            <td><input class="form-control" type="text" value="<?php echo $newtimebooked;?>" readonly></td>
          </tr>
          <tr>
            <td><b>Client Name</b></td>
            <td> : </td>
            <td><input class="form-control" type="text" value="<?php echo $cfname; echo' '; echo $clname;?>" readonly></td>
          </tr>
          <tr>
            <td><b>Address</b></td>
            <td> : </td>
            <td><input class="form-control" type="text" value="<?php echo $address;?>" readonly></td>
          </tr>
          <tr>
            <td><b>Contact Number</b></td>
            <td> : </td>
            <td><input class="form-control" type="text" value="<?php echo $contactno;?>" readonly></td>
          </tr> 
          <tr>
            <td><b>Description</b></td>
            <td> : </td>
            <td><textarea class="form-control" rows="5" style="resize:none" readonly><?php echo $description;?></textarea></td>
          </tr>
          <tr>
            <td><b>Date of Repair</b></td>
            <td> : </td>
            <td><input class="form-control" type="text" value="<?php echo $newdateob;?>" readonly></td>
          </tr> 
          <tr>
            <td><b>Time of Repair</b></td>
            <td> : </td>
            <td><input class="form-control" type="text" value="<?php echo $newtimeob;?>" readonly></td>
          </tr>
          <tr>
            <td><b>Fee:</b></td>
            <td> : </td>
            <td><input class="form-control" type="text" value="₱ <?php echo $fee;?>"readonly></td>
          </tr>
          <tr>
            <td><b>Status</b></td>
            <td> : </td>
            <td><?php echo "<font style='color:blue'>".$status;?></td>
          </tr> 
          <tr>
            <td colspan="5" align="center">
              <?php
              if($status != 'Canceled' AND $status != 'Approved' AND $status != 'Declined' AND $status != 'Complete')
                { ?>
                  <form action="#.php" method="post" enctype="multipart/form-data">
                    <input class="btn btn-success" type="submit" name="accept" value="Accept" style="width:100px" onclick="return confirm('Accept Booking?')">&nbsp
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cancel" style="width:100px">Decline</button>
                  </form>
          <?php }
              if ($status == 'Declined')
                {
                  echo '<tr>';
                  echo '<td><b>Reason</b></td>';
                  echo '<td> : </td>';
                  echo '<td><b>'.$reason.'</b></td>';
                  echo '</tr>';
                }
              ?>
            </td>
          </tr>
        </table>
    </center><br>
  </div>
    <form action="#.php" method="post" enctype="multipart/form-data">
      <div id="cancel" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content" style="width:500px;">
            <div class="modal-header">
              <h4 class="modal-title">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Cancel Booking</b></h4>
            </div>
            <div class="modal-body">
              <table>
                <tr>
                  <td width="120px"><b>Client Name :</b></td>
                  <td width="10px"></td>
                  <td><?php echo $cfname; echo '&nbsp&nbsp'; echo $clname; ?></td>
                </tr>
                <tr><td> &nbsp</td></tr>
                <tr>
                  <td><b>Reason<br></b></td>
                  <td></td>
                </tr>
              </table>
              <select class="form-control" name="reason" required="required" id="inputreason" placeholder="Reason" style="width:450px !important">
                <option style="display:none" disabled selected>Choose a reason</option>
                  <option value="Conflict with other booking">Conflict with other booking</option>
                  <option value="Repairman already in a booking">Repairman already in a booking</option>
                  <option value="Not available on date of repair">Not available on date of repair</option>
                  <option value="Not available on time of repair">Not available on time of repair</option>
                  <option value="Others">Others</option>
              </select>
            </div>
            <div class="modal-footer">
              <input class="btn btn-warning" type="submit" name="decline" value="Decline" style="width:110px">
              <button type="button" class="btn btn-default" style="width:110px" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<br>
<?php include('../includes/footer.php') ?>
</body>
</html>