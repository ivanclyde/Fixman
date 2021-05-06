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
	  $category = $dis['category'];
	}

  $res = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
  while ($rows = mysqli_fetch_array($res)) 
  {
    $fname = $rows['fname'];
    $lname = $rows['lname'];
    $profilepix = $rows['profilepix'];
  }

  $resultfeedback = mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE bookingid = '$bookingid'");
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

  $feedback = mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE bookingid = '$bookingid'");
  while ($fee = mysqli_fetch_array($feedback)) 
  {
    $created = date('F d, Y', strtotime($fee['created']));
    $content = $fee['feedback'];
  }

  $result = mysqli_query($database, "SELECT * FROM booking WHERE bookingid = '$bookingid' ORDER BY status ASC");
  while ($row = mysqli_fetch_array($result)) 
  {
    $repairmanid = $row['repairmanid'];
  }

  if(isset($_POST['submit']))
  {
    $userid = mysqli_real_escape_string($database,$_SESSION['userid']);
    $bookingid = mysqli_real_escape_string($database,$_POST['bookingid']);
    $rate = mysqli_real_escape_string($database,$_POST['rate']);
    $feedback = mysqli_real_escape_string($database,$_POST['feedback']);
    $created = mysqli_real_escape_string($database,$_POST['created']);

    $notifid = substr(md5(uniqid(mt_rand(), true)) , 0, 5);
    $notifto = $repairmanid;
    $notiffrom = mysqli_real_escape_string($database,$_SESSION['userid']);
    $content = $fname.' '.$lname.' has rated and given you feedback.';
    $link = 'http://localhost/fixman/repairman/repairmanviewbookingsummary.php?bookingid='.$bookingid.'&userid='.$userid.'&notifid='.$notifid;

    mysqli_query($database, "UPDATE booking SET status='Complete' WHERE bookingid='$bookingid'");
    mysqli_query($database, "UPDATE repairman SET transaction='Available' WHERE repairmanid='$repairmanid'");
    mysqli_query($database, "INSERT INTO notification(notifid, notifto, notiffrom, content, link, created, status) VALUES ('$notifid','$notifto','$notiffrom','$content','$link',CURRENT_TIMESTAMP,'0')");
    $sql = "INSERT INTO ratingsandfeedback (bookingid, userid, repairmanid, rate, feedback, created) VALUES ('$bookingid','$userid','$repairmanid','$rate','$feedback', '$created')";
    mysqli_query($database, $sql);

    echo "<script>alert('Ratings and Feedback given successfully.'); window.location.href='bookingsummary.php?bookingid=$bookingid&repairmanid=$repairmanid'</script>";
  }
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
  	.rating td {
  		  padding: 5px;
  	}
    .rate {
        padding-right: 200px;
        padding-top: 0px;
        padding-bottom: 0px;
    }
    .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#000;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700;    
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }
    .hideme {
      display: none;
    }
  </style>
</head>
<body>	
<?php 
  include('userheader.php');
?>

<a href="customerviewbookings.php"><button class="btn btn-light"><i class="bi bi-caret-left"></i>Back</button></a>

<div class="container-fluid text-center">
    	<center><table style="border:0px;border-radius:25px;background-color:#59E817;">
    		<thead><tr>
    			<th class="steps"><i class="bi bi-calendar-range"></i> Booking Details </th>
    			<th class="steps"><i class="bi bi-credit-card"></i> Payment Options</th>
    			<th class="steps" style="background-color:lightgreen"><i class="bi bi-star-fill"></i> Ratings and Feedbacks</th>
    		</tr></thead>
    	</table></center><br>

  <div align="left" style="background-color:#F7FAFF;width:900px;border-radius:10px;margin-left:210px">
    <center>
      <label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-star-fill"></i> Ratings and Feedbacks</h2></b></label>
      <div class="col-sm-12" style="text-align:left;background-color:#E5E4E2;border-radius:10px;width:400px;padding-bottom:10px">
          <?php 
          if(mysqli_num_rows($resultfeedback) == 1)
          { ?>
              <tr>
                <td><h4><b><?php echo $category?></b></h4></td>
              </tr>
              <tr>
                <td>&emsp;&emsp;&emsp;<?php echo $rfname.'&nbsp&nbsp'; echo $rlname;?></td>
              </tr>
              <tr>
                <td><h4><b>Rate</b></h4></td>
              </tr>
              <tr>
                <td>&emsp;&emsp;&emsp;<?php while ($feed = mysqli_fetch_array($resultfeedback)){ echo drawStars($feed['rate']); }?></td>
              </tr>
              <tr>
                <td><h4><b>Feedback</b></h4></td>
              </tr>
              <tr>
                <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<?php echo $created?></td>
              </tr>
              <br>
              <tr>
                <td>&emsp;&emsp;<?php echo $content?></td>
              </tr>
    <?php }
          else
          { ?>
            <form action="#.php" method="post" enctype="multipart/form-data">
              <table class="rating">
                <input type="hidden" name="created" value="<?php echo date('Y-m-d'); ?>" >
                <input type="hidden" name="repairmanid" value=<?php echo $repairmanid ?>>
                <input type="hidden" name="bookingid" value=<?php echo $bookingid ?>>
                <tr>
                  <td><h3><b><?php echo $category?></b></h3></td>
                </tr>
                <tr>
                  <td>&emsp;&emsp;&emsp;<?php echo $rfname.'&nbsp&nbsp'; echo $rlname;?></td>
                </tr>
                <tr>
                  <td><h3><b>Rate</b></h3></td>
                </tr>
                <tr>
                  <td class="rate">
                  <input type="radio" name="rate" id="star5" value="5"/>
                  <label for="star5" title="5 stars">5 stars</label>
                  <input type="radio" name="rate" id="star4" value="4"/>
                  <label for="star4" title="4 stars">4 stars</label>
                  <input type="radio" name="rate" id="star3" value="3"/>
                  <label for="star3" title="3 stars">3 stars</label>
                  <input type="radio" name="rate" id="star2" value="2"/>
                  <label for="star2" title="2 stars">2 stars</label>
                  <input type="radio" name="rate" id="star1" value="1"/>
                  <label for="star1" title="1 star">1 star</label>
                  <input class="hideme" type="radio" name="rate" id="star5" value="5" checked/>
                  <label class="hideme" for="star5" title="5 stars">5 stars</label>
                  </td>
                </tr>
                <tr>
                  <td><h3><b>Feedback</b></h3>
                  <textarea class="form-control" cols="50" rows="5" name="feedback" required="required" placeholder="Give Feedback..."></textarea></td>
                </tr>
                <tr>
                  <td align="center"><br><input class="btn btn-success" type="submit" name="submit" value="Give Feedback" required="required"></td>
                </tr>
            </table>
          </form>
    <?php } ?>
      </div><br>
  </div>    

      
</div>
<br>

<?php include('../includes/footer.php'); ?>
</body>
</html>