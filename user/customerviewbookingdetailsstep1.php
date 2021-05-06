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

  $repairman = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
  while ($rep = mysqli_fetch_array($repairman)) 
  {
    $rfname = $rep['fname'];
    $raddress = $rep['address'];
    $rlname = $rep['lname'];
    $rcontactno = $rep['contactno'];
  }

  $users = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
  while ($use = mysqli_fetch_array($users)) 
  {
    $fname = $use['fname'];
    $profilepix = $use['profilepix'];
  }

  $result = mysqli_query($database, "SELECT * FROM booking WHERE bookingid = '$bookingid'ORDER BY status ASC");
  while ($row = mysqli_fetch_array($result)) 
  {
    $repairmanid = $row['repairmanid'];
    $description = $row['description'];
    $timeob = $row['timeob'];
    $description = $row['description'];
    $dateob = $row['dateob'];
    $newdate = date('F d, Y', strtotime($row['dateob']));
    $newtimeob = date('h:i A', strtotime($row['timeob']));
    $fee = $row['fee'];
    $category = $row['category'];
    $status = $row['status'];
    $reason = $row['reason'];
  }

  if(isset($_POST['reschedule']))
  {
    $description = mysqli_real_escape_string($database,$_POST['description']);
    $dateob = mysqli_real_escape_string($database, $_POST['dateob']);
    $timeob = mysqli_real_escape_string($database, $_POST['timeob']);

    $notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
    $notifto = $repairmanid;
    $notiffrom = mysqli_real_escape_string($database,$_SESSION['userid']);
    $content = 'A booking has been rescheduled.';
    $link = 'http://localhost/fixman/repairman/repairmanviewbookingstep1.php?bookingid='.$bookingid.'&userid='.$userid.'&notifid='.$notifid;
    
    $dateob = date('m/d/Y', strtotime($dateob));
    $date = date('m/d/Y');
    if($dateob < $date)
    {
      echo "<script>alert('You cannot choose date behind the current date...'); window.location.href='customerviewbookingdetailsstep1.php?bookingid=$_GET[bookingid]&repairmanid=$_GET[repairmanid]'</script>";
    }
    else
    {
      $sql = "UPDATE booking SET description='$description', dateob='$dateob', timeob='$timeob',status='Rescheduled', timebooked=CURRENT_TIMESTAMP WHERE bookingid='$bookingid'";
      mysqli_query($database, $sql);
      mysqli_query($database, "INSERT INTO notification(notifid, notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
      echo "<script>alert('Rechedule for booking has been submitted, please wait for update...'); window.location.href='customerviewbookingdetailsstep1.php?bookingid=$_GET[bookingid]&repairmanid=$_GET[repairmanid]'</script>";
    }
  }
    if (isset($_POST['cancel'])) 
    {
      $reason = mysqli_real_escape_string($database, $_POST['reason']);

      $notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
      $notifto = $repairmanid;
      $notiffrom = mysqli_real_escape_string($database,$_SESSION['userid']);
      $content = 'A booking has been canceled.';
      $link = 'http://localhost/fixman/repairman/repairmanviewbookingstep1.php?bookingid='.$bookingid.'&userid='.$userid.'&notifid='.$notifid;

      mysqli_query($database, "INSERT INTO notification(notifid,notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
      mysqli_query($database, "UPDATE booking SET status='Canceled' , reason = '$reason' WHERE bookingid='$bookingid'");
      echo "<script>alert('Booking has been canceled!'); window.location.href='customerviewbookingdetailsstep1.php?bookingid=$_GET[bookingid]&repairmanid=$_GET[repairmanid]';</script>";
    }
?>

<!DOCTYPE html>
<html>
<head>
  	<title>Bookings Details</title>
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
<?php include('userheader.php'); ?>

<a href="customerviewbookings.php"><button class="btn btn-light"><i class="bi bi-caret-left"></i>Back</button></a>

<div class="container-fluid">
      <center><table style="border:0px;border-radius:25px;background-color:#59E817;">
        <thead><tr>
          <th class="steps" style="background-color:lightgreen"><i class="bi bi-calendar-range"></i> Booking Details </th>
          <th class="steps"><i class="bi bi-credit-card"></i> Payment Options</th>
          <th class="steps"><i class="bi bi-star-fill"></i> Ratings and Feedback</th>
        </tr></thead>
      </table></center><br>
  <div align="left" style="background-color:#F7FAFF;width:900px;border-radius:10px;margin-left:210px"> <center><label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-calendar-range"></i> Booking Details</h2></b></label>
      <form action="#.php" method="post" enctype="multipart/form-data">
      <table class="bookdetails" style="background-color:#E5E4E2;border-radius: 15px;padding:6px">
        <tr>
          <td><b><?php echo$category?></b></td>
          <td> : </td>
          <td><?php echo $rfname; echo '&nbsp'; echo $rlname;?></td>
        </tr>
        <tr><td colspan="3"><hr></td></tr>
        <tr>
          <td><b>Address</b></td>
          <td> : </td>
          <td><?php echo $raddress;?></td>
        </tr>
        <tr>
          <td><b>Contact Number</b></td>
          <td> : </td>
          <td><?php echo $rcontactno;?></td>
        </tr> 
        <tr>
          <td><b>Description</b></td>
          <td> : </td>
          <td><?php echo $description;?></td>
        </tr>
        <tr>
          <td><b>Date of Repair</b></td>
          <td> : </td>
          <td><?php echo $newdate;?></td>
        </tr> 
        <tr>
          <td><b>Time of Repair</b></td>
          <td> : </td>
          <td><?php echo $newtimeob;?></td>
        </tr>
        <tr>
          <td><b>Fee</b></td>
          <td> : </td>
          <td>₱ <?php echo $fee;?></td>
        </tr>
        <tr>
          <td><b>Category</b></td>
          <td> : </td>
          <td><?php echo $category;?></td>
        </tr>
        <tr>
          <td><b>Status</b></td>
          <td> : </td>
          <td><?php echo "<font style='color:blue'>".$status;?></td>
        </tr> 
        <tr>
          <?php
          if($status == 'Pending' OR $status == 'Rescheduled')
            {
              echo '<td colspan="3" align="center"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#reschedule" style="width:120px">Reschedule</button>&nbsp&nbsp<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cancel" style="width:120px">Cancel</button></td>';
            }
          if ($status == 'Declined') 
            {
              echo '<tr>';
              echo '<td><b>Reason</b></td>';
              echo '<td> : </td>';
              echo '<td><b>'.$reason.'</b></td>';
              echo '</tr>';
            }
          ?>
        </tr>
        <tr><td></td></tr>
        </table>
      </form>
      </center>
      <br>
  </div>
    <!--- Modal for Reschedule --->
    <form action="#.php" method="post" enctype="multipart/form-data">
      <div id="reschedule" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content" style="width:500px;">
            <div class="modal-header">
              <h4 class="modal-title">&emsp;&emsp;&emsp;&emsp;&nbsp&nbsp&nbsp<b>Reschedule Booking</b></h4>
            </div>
            <div class="modal-body">
              <table>
                <tr>
                  <td width="150px"><b>Name </b></td>
                  <td width="20px"></td>
                  <td><?php echo $rfname; echo '&nbsp&nbsp'; echo $rlname; ?></td>
                </tr>
                <tr>
                  <td><b>Address </b></td>
                  <td></td>
                  <td><?php echo $raddress; ?></td>
                <tr>
                  <td><b>Contact Number </b></td>
                  <td></td>
                  <td><?php echo $rcontactno;?></td>
                </tr>
                <tr>
                  <td><b>Description</b></td>
                  <td></td>
                  <td><textarea class="form-control" cols="40" rows="5" name="description" required="required"><?php echo $description?></textarea></td>
                </tr>
                <tr>
                  <td><b>Date of Booking</b></td>
                  <td></td>
                  <td><input class="form-control book" style="width:200px" type="date" name="dateob" required="required" value=<?php echo $dateob;?>></td>
                </tr>
                <tr>
                  <td><b>Time of Booking</b></td>
                  <td></td>
                  <td><input class="form-control book" style="width:200px" type="time" name="timeob" required="required" value=<?php echo $timeob;?>></td>
                </tr>
              </table>
            </div>
            <div class="modal-footer">
              <input class="btn btn-success" type="submit" name="reschedule" value="Reschedule">
              <button type="button" class="btn btn-default" style="width:110px" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>
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
                  <td width="100px"><b><?php echo$category ?> </b></td>
                  <td width="10px"></td>
                  <td><?php echo $rfname; echo '&nbsp&nbsp'; echo $rlname; ?></td>
                </tr>
                <tr><td> &nbsp</td></tr>
                <tr>
                  <td><b>Reason<br></b></td>
                  <td></td>
                </tr>
              </table>
              <select class="form-control" name="reason" required="required" id="inputreason" placeholder="Reason" style="width:450px">
                <option style="display:none" disabled selected>Choose a reason</option>
                  <option value="Repairman is expensive">Repairman is expensive</option>
                  <option value="Change of schedule">Change of schedule</option>
                  <option value="Problem already fixed">Problem already fixed</option>
                  <option value="Found another <?php echo$category?>">Found another <?php echo$category?></option>
                  <option value="Others">Others</option>
              </select>
            </div>
            <div class="modal-footer">
              <input class="btn btn-warning" type="submit" name="cancel" value="Cancel" style="width:110px">
              <button type="button" class="btn btn-default" style="width:110px" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>
</div>
<br>


<?php include('../includes/footer.php'); ?>
</body>
</html>