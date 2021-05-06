<?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../includes/config.php');

	$userid = $_SESSION['userid'];
 	$repairmanid = $_GET['repairmanid'];

  $resultfeedback = mysqli_query($database, "SELECT * FROM ratingsandfeedback INNER JOIN users ON ratingsandfeedback.userid=users.userid WHERE ratingsandfeedback.repairmanid = $repairmanid ORDER BY created DESC LIMIT 5");
  function drawStars(int $starRating)
  {
    echo "<span style='color:  #FFFF00;font-size:25px'>";
    for ($i = 0; $i < $starRating; $i++)
    {
      echo "&#x2605;";
    }
    echo "</span>";
    echo "<span style='font-size:25px'>";
    for ($i = 5 - $starRating; $i > 0; $i--)
    {
      echo "&#x2605;";
    }
  }

  $result = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
  while ($row = mysqli_fetch_array($result)) 
  {
      $repairmanid = $row['repairmanid'];
    	$rfname = $row['fname'];
  	  $rlname = $row['lname'];
      $age = $row['age'];
      $bdate = $row['bdate'];
      $raddress = $row['address'];
      $rcontactno = $row['contactno'];
      $email = $row['email'];
      $gender = $row['gender'];
      $category = $row['category'];
      $rprofilepix = $row['profilepix'];
      $fee = $row['fee'];
  }
  
  $results = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
  while ($res = mysqli_fetch_array($results)) 
  {
      $fname = $res['fname'];
      $cmname = $res['mname'];
      $clname = $res['lname'];
      $caddress = $res['address'];
      $ccontactno = $res['contactno'];
      $profilepix = $res['profilepix'];
  }

  if(isset($_POST['reschedule']))
  {
    $description = mysqli_real_escape_string($database,$_POST['description']);
    $dateob = mysqli_real_escape_string($database, $_POST['dateob']);
    $timeob = mysqli_real_escape_string($database, $_POST['timeob']);
    $bookingid = mysqli_real_escape_string($database, $_POST['bookingid']);

    $notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
    $notifto = $repairmanid;
    $notiffrom = mysqli_real_escape_string($database,$_SESSION['userid']);
    $content = 'A booking has been rescheduled.';
    $link = 'http://localhost/fixman/repairman/repairmanviewbookingstep1.php?bookingid='.$bookingid.'&userid='.$userid.'&notifid='.$notifid;
    
    $date = date('Y-m-d');
    if($dateob < $date)
    {
      echo "<script>alert('You cannot choose date behind the present date...'); window.location.href='viewrepairman.php?repairmanid=$_GET[repairmanid]'</script>";
    }
    else
    {
      $sql = "UPDATE booking SET description='$description', dateob='$dateob', timeob='$timeob',status='Rescheduled', timebooked=CURRENT_TIMESTAMP WHERE bookingid='$bookingid'";
      mysqli_query($database, $sql);
      mysqli_query($database, "INSERT INTO notification(notifid, notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
      echo "<script>alert('Booking has been submitted, please wait for the update...'); window.location.href='customerviewbookingdetailsstep1.php?repairmanid=$_GET[repairmanid]&bookingid=$bookingid'</script>";
    }
  }

  if(isset($_POST['submitbooking']))
  {
  	$bookingid = substr(md5(uniqid(mt_rand(), true)) , 0, 6);
  	$userid = mysqli_real_escape_string($database,$_SESSION['userid']);
  	$repairmanid = mysqli_real_escape_string($database, $_GET['repairmanid']);
  	$description = mysqli_real_escape_string($database,$_POST['description']);
  	$dateob = mysqli_real_escape_string($database, $_POST['dateob']);
  	$timeob = mysqli_real_escape_string($database, $_POST['timeob']);
  	$category = mysqli_real_escape_string($database, $_POST['category']);
  	$fee = mysqli_real_escape_string($database, $_POST['fee']);

  	$notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
  	$notifto = mysqli_real_escape_string($database,$_GET['repairmanid']);
  	$notiffrom = mysqli_real_escape_string($database,$_SESSION['userid']);
  	$content = 'You have a new booking.';
  	$link = 'http://localhost/fixman/repairman/repairmanviewbookingstep1.php?bookingid='.$bookingid.'&userid='.$userid.'&notifid='.$notifid;

    $date = date('Y-m-d');
    if($dateob < $date)
    {
      echo "<script>alert('You cannot choose date behind the present date...'); window.location.href='viewrepairman.php?repairmanid=$_GET[repairmanid]'</script>";
    }
    else
    {
      $sql = "INSERT INTO booking(bookingid, userid, repairmanid, description, timebooked, dateob, timeob, category, fee, status) VALUES ('$bookingid','$userid','$repairmanid','$description',CURRENT_TIMESTAMP,'$dateob','$timeob','$category','$fee','Pending')";
      mysqli_query($database, $sql);
      mysqli_query($database, "INSERT INTO notification(notifid, notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
      echo "<script>alert('Booking has been submitted, please wait for the update...'); window.location.href='customerviewbookingdetailsstep1.php?repairmanid=$_GET[repairmanid]&bookingid=$bookingid'</script>";
    }
  }

  if(isset($_POST['submitmessage']))
  {
    if(empty($_POST['inputchatid']))
    {
      date_default_timezone_set('Asia/Manila');
      $messfrom = mysqli_real_escape_string($database, $_SESSION['userid']);
      $messto = mysqli_real_escape_string($database, $_GET['repairmanid']);
      $content = mysqli_real_escape_string($database, $_POST['content']);
      $emchatid = substr(md5(uniqid(mt_rand(), true)) , 0, 10);

      mysqli_query($database,"INSERT INTO message(messto, messfrom, content, chatid,  created, useen, rseen) VALUES ('$messto','$messfrom','$content','$emchatid',CURRENT_TIMESTAMP,'1','0')");
      echo "<script>alert('Message Sent.'); window.location.href='viewrepairman.php?repairmanid=$_GET[repairmanid]'</script>";
    }
    else
    {
      date_default_timezone_set('Asia/Manila');
      $messfrom = mysqli_real_escape_string($database, $_SESSION['userid']);
      $messto = mysqli_real_escape_string($database, $_GET['repairmanid']);
      $content = mysqli_real_escape_string($database, $_POST['content']);
      $nechatid = mysqli_real_escape_string($database, $_POST['inputchatid']);

      mysqli_query($database,"INSERT INTO message(messto, messfrom, content, chatid,  created, useen, rseen) VALUES ('$messto','$messfrom','$content','$nechatid',CURRENT_TIMESTAMP,'1','0')");
      echo "<script>alert('Message Sent.'); window.location.href='viewrepairman.php?repairmanid=$_GET[repairmanid]'</script>";
    }
  }

  $book = mysqli_query($database, "SELECT * FROM booking WHERE userid = '$_SESSION[userid]' AND repairmanid = '$repairmanid'  AND status = 'Pending' OR status = 'Rescheduled'");
  while ($boo = mysqli_fetch_array($book))
  {
    $timeob = $boo['timeob'];
    $dateob = $boo['dateob'];
    $description = $boo['description'];
    $bookingid = $boo['bookingid'];
  }

  $message = mysqli_query($database, "SELECT * FROM message WHERE messto = '$userid' AND messfrom = '$repairmanid' OR messto = '$repairmanid' AND messfrom = '$userid'");
  while ($mess = mysqli_fetch_array($message))
  {
    $chatid = $mess['chatid'];
  }

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Repairman's Profile</title>
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
.table>tbody>tr>td,
.table>tbody>tr>th {
    border-top: none;
    padding: 5px !important;
}
</style>
</head>
<body>
<input type="hidden" name="size" value="1000000">
<?php include('userheader.php') ?>
<button class="btn btn-light" onclick="location.href='customerhomepageview.php';"/><i class="bi bi-caret-left"></i> Back</button>
<div class="container-fluid text-center" style="background-color:#F7FAFF;width:900px;border-radius:10px">    
  <div class="row content text-left" style="margin-left:100px">
    <table>
      <tr>
        <td style="width:250px"><div class="img_div">
            <img src="../profilepix/<?php echo $rprofilepix ?>" width ="200px" height="200px" style="border-radius:100px">
        </div></td>
        <td>
          <h3><?php echo $rfname ?> <?php echo $rlname ?></h3>
          <h6>( <?php echo$category; ?> )</h6>
          <h7><b>Rating :</b> <?php if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } ?></h7>
          <hr>
          <label><b>Fee : </b><?php echo '<p style="color:blue;display:inline">';echo '₱ '; echo number_format($fee, 2); echo ' / day</p>';?>&nbsp&nbsp<a target="_blank" title="Fee's may vary according to the complexity of the repair. and the number of working days needed to finish the repair."><img src="https://shots.jotform.com/kade/Screenshots/blue_question_mark.png" height="15px"/></a></label><br>
  	      <label><b>Address : </b><?php echo $raddress;?></label><br>
  	      <label><b>Gender : </b><?php echo $gender;?></label><br>
  	      <label><b>Contact Number : </b><?php echo $rcontactno;?></label><br>
  	      <label><b>Email : </b><?php echo $email;?></label><br>
        </td>
      </tr>
      <tr>
      	<td><td>
      	<p><button type="button" class="btn btn-primary" style="width:120px" data-toggle="modal" data-target="#message">Message</button>&nbsp<?php if(mysqli_num_rows($book) > 0) { echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reschedule" style="width:120px">Reschedule</button>'; } else{ echo '<button type="button" class="btn btn-primary" style="width:120px" data-toggle="modal" data-target="#booking">Book</button>'; } ?>&nbsp<a class="btn btn-primary" style="width:120px" target="_blank" href="profile.php?repairmanid=<?php echo $repairmanid?>">Profile</a>
        </p> 
      </tr>
    </table>
  </div>
  <hr width="900px">
  <h1 align="center">Ratings and Feedbacks</h1>
  <br>
  <?php
  if (mysqli_num_rows($resultfeedback) == 0)
  {
    echo '<center><div class="alert alert-info" role="alert" style="width:900px; border-radius:20px;">';
    echo '<h3 align="center" class="alert-heading">No Feedbacks</h3>';
    echo '</div></center>';
  }
  else
  {
    while ($rows = mysqli_fetch_array($resultfeedback))
    {
      echo '<center><div style="background-color:#f1f1f1;border-radius:10px;width:700px;"><table class="table" style="margin-bottom:10px"><tr>';
      echo '<td rowspan="3" width="70px""><img class="img-dis" src="../profilepix/'.$rows['profilepix'].'"style="border-radius:50px;width: 80px;height: 80px;margin-top: 10px;"></td>';
      echo '<th class="text-left">'.$rows['fname'].' '.$rows['lname'].'</th>';
      echo '<th class="text-right">'.$newcreated = date('F d, Y', strtotime($rows['created'])).'</th>';
      echo '</tr>';
      echo '<tr><td colspan="3">';
      echo drawStars($rows['rate']);
      echo '</td></tr>';
      echo '<tr>';
      echo '<td colspan="3">'.$rows['feedback'].'</td>';
      echo '</tr></table></div></center>';
    }
  }
?>
</div>
<form action="#.php" method="post" enctype="multipart/form-data">
      <div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="#.php" method="post">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="width:auto;right:25px">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">&emsp;&emsp;&emsp;&emsp;&emsp;<b>Message Repairman</b></h4>
            </div>
            <div class="modal-body">
              <table style="text-align:left">
                <?php 
                  if(isset($chatid))
                  {
                    echo '<input type="hidden" name="inputchatid" value='.$chatid.'>';
                  }
                ?>
                <tr>
                  <td><b>From</b></td>
                  <td><?php echo $fname; echo '&nbsp&nbsp'; echo $clname?></td>
                </tr>
                <tr>
                  <td><b>To</b></td>
                  <td><?php echo $rfname; echo '&nbsp&nbsp'; echo $rlname?></td>
                </tr>
                <tr>
                  <td><b>Message</b></td>
                  <td><textarea class="form-control" cols="40" rows="5" name="content" placeholder="Message..." required="required" style="resize:none"></textarea></td>
                </tr>
              </table>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success" name="submitmessage">Send</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <form action="#.php" method="post" enctype="multipart/form-data">
      <div class="modal fade" id="booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="width:550px;right:25px">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Book <?php echo$category ?></b></h4>
            </div>
            <div class="modal-body">
              <table style="text-align:left">
                <input type="hidden" name="fee" value=<?php echo $fee?>>
                <input type="hidden" name="category" value=<?php echo $category?>>
                <tr>
                  <td width="150px"><b><?php echo$category?></b></td>
                  <td><?php echo $rfname; echo str_repeat('&nbsp;', 2); echo $rlname?></td>
                </tr>
                <tr>
                  <td><b>Address</b></td>
                  <td><?php echo $raddress; ?></td>
                </tr>
                <tr>
                  <td><b>Contact Number</b></td>
                  <td><?php echo $rcontactno; ?></td>
                </tr>
                <tr>
                  <td><b>Description</b></td>
                  <td><textarea class="form-control" cols="45" rows="5" name="description" required="required" placeholder="Short description..." style="resize:none"></textarea></td>
                </tr>
                <tr>
                  <td><b>Booking Date</b></td>
                  <td><input class="form-control book" style="width:200px" type="date" name="dateob" required="required"></td>
                </tr>
                <tr>
                  <td><b>Booking Time</b></td>
                  <td><input class="form-control book" style="width:200px" type="time" name="timeob" required="required" ></td>
                </tr>
              </table>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success" name="submitbooking">Book</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <form action="#.php" method="post" enctype="multipart/form-data">
      <div id="reschedule" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content" style="width:500px;">
            <div class="modal-header">
              <h4 class="modal-title">&emsp;&emsp;&emsp;&emsp;&nbsp&nbsp<b>Reschedule Booking</b></h4>
            </div>
            <div class="modal-body" style="text-align:left">
              <input type="hidden" name="bookingid" value="<?php echo$bookingid ?>">
              <table>
                <tr>
                  <td width="130px"><b>Name </b></td>
                  <td width="20px"></td>
                  <td><?php echo $rfname; echo '&nbsp&nbsp'; echo $rlname; ?></td>
                </tr>
                <tr>
                  <td><b>Address </b></td>
                  <td></td>
                  <td><?php echo $raddress; ?></td>
                <tr>
                  <td width="150px"><b>Contact Number </b></td>
                  <td></td>
                  <td><?php echo $rcontactno;?></td>
                </tr>
                <tr>
                  <td><b>Description</b></td>
                  <td></td>
                  <td><textarea class="form-control" cols="45" rows="5" name="description" required="required"><?php echo $description?></textarea></td>
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
<br>

<?php include('../includes/footer.php'); ?>
</body>
</html>