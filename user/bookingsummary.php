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

  $result = mysqli_query($database, "SELECT * FROM booking WHERE bookingid = '$bookingid'");
 	while ($row = mysqli_fetch_array($result)) 
  	{
	    $description = $row['description'];
	    $status = $row['status'];
	    $fee = $row['fee'];
	    $category = $row['category'];
	    $dateob = $row['dateob'];
	    $endob = $row['endob'];
      $totalfee = $row['totalfee'];
      $totaldays = $row['totaldays'];
	    $newdateob = date('F d, Y', strtotime($row['dateob']));
	    $newtimeob = date('h:i A', strtotime($row['timeob']));
	    $newtimebooked = date('F d, Y h:i A', strtotime($row['timebooked']));
	    $newendob = date('F d, Y', strtotime($row['endob']));
  	}
  	
  $users = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
	while ($use = mysqli_fetch_array($users)) 
	{
	  $fname = $use['fname'];
    $lname = $use['lname'];
	  $profilepix = $use['profilepix'];
	}

  $repairman = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
  while ($rep = mysqli_fetch_array($repairman)) 
  {
    $rfname = $rep['fname'];
    $rlname = $rep['lname'];
    $raddress = $rep['address'];
    $remail = $rep['email'];
    $category = $rep['category'];
    $rcontactno = $rep['contactno'];
    $rprofilepix = $rep['profilepix'];
  }

  $resultfeedback = mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE bookingid='$bookingid'");
  function drawStars(int $starRating)
  {
    echo "<span style='color:#FFFF00;font-size:25px;'>";
    for ($i = 0; $i < $starRating; $i++)
    {
      echo "&#x2605;";
    }
    echo "</span>";
    echo "<span style='font-size:25px;'>";
    for ($i = 5 - $starRating; $i > 0; $i--)
    {
      echo "&#x2605;";
    }
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
  .steps th {
  	text-align: center;
  	width: 300px;
  	height: 50px;
  	border-radius: 50px;
  	font-size: 20px;
  }
  .receipt td {
  	padding: 5px;
  }
  .details td{
    padding: 5px;
  }
  .receipt {
    background-color: #f1f1f1;
    border-radius: 10px;
    border:1px solid;
  }
  .table>tbody>tr>td,
  .table>tbody>tr>th {
    border-top: none;
    padding: 5px !important;
    font-size: 1.2em !important;
  }
</style>
</head>
<body>	
<?php 
  include('userheader.php')
?>

<a href="customerviewbookings.php"><button class="btn btn-light"><i class="bi bi-caret-left"></i>Back</button></a>

<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-lg-12" align="left">
    	<center><table class="steps" border="0" style="background-color:#59E817;border-radius:25px">
    		<thead><tr>
    			<th style="background-color:lightgreen;"><i class="bi bi-card-list"></i> Summary</th>
    		</tr></thead>
    	</table></center>
    </div>
      <hr width="900px">
      <div align="left" style="background-color:#F7FAFF;width:900px;border-radius:10px;margin-left:225px">
        <center><label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-person"></i> Repairman Details</h2></b></label></center>
          <table class="profile" style="margin-left:150px">
            <tr>
              <td style="width:250px"><div class="img_div">
                  <img src="../profilepix/<?php echo $rprofilepix ?>" width ="150px" height="150px" style="border-radius:100px">
              </div></td>
              <td>
                <label><b>Category : </b><?php echo $category;?></label><br>
                <label><b>Name : </b><?php echo $rfname; echo '&nbsp&nbsp'; echo $rlname;?></label><br>
                <label><b>Address : </b><?php echo $raddress;?></label><br>
                <label><b>Contact Number : </b><?php echo $rcontactno;?></label><br>
                <label><b>Email : </b><?php echo $remail;?></label><br>
              </td>
            </tr>
          </table><br>
      	<center><label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-calendar-range"></i> Booking Details</h2></b></label>
      	<table class="details" style="background-color:#F1F1F1;border-radius:10px;border:1px solid">
          <tr>
            <td><b><?php echo $category?></b></td>
            <td><?php echo $rfname; echo'&nbsp'; echo $rlname;?></td>
          </tr>
          <tr>
            <td><b>Address</b></td>
            <td><?php echo $raddress;?></td>
          </tr>
          <tr>
            <td><b>Contact Number</b></td>
            <td><?php echo $rcontactno;?></td>
          </tr> 
          <tr>
            <td><b>Description</b></td>
            <td><?php echo $description;?></td>
          </tr>
          <tr>
            <td><b>Date of Repair</b></td>
            <td><?php echo $newdateob;?></td>
          </tr> 
          <tr>
            <td><b>Time of Repair</b></td>
            <td><?php echo $newtimeob;?></td>
          </tr>
          <tr>
            <td><b>Time Booked</b></td>
            <td><?php echo $newtimebooked;?></td>
          </tr>
          <tr>
            <td><b>Fee:</b></td>
            <td>₱ <?php echo number_format($fee, 2)?></td>
          </tr>
          <tr>
            <td><b>Category</b></td>
            <td><?php echo $category;?></td>
          </tr>
          <tr>
            <td><b>Status</b></td>
            <td><?php echo "<font style='color:blue'>".$status;?></td>
          </tr> 
      	</table><br>
        <label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-receipt"></i> Receipt</h2></b></label>
        <table class="receipt">
          <tr>
            <td><b>Client Name</b></td>
            <td></td>
            <td><?php echo $fname; echo'&nbsp'; echo $lname?></td>
          </tr>
          <tr>
            <td><b><?php echo $category ?></b></td>
            <td></td>
            <td><?php echo $rfname; echo'&nbsp'; echo $rlname;?></td>
          </tr>
          <tr><td colspan="3"><hr style="margin-top:0px;margin-bottom:0px;"></td></tr>
          <tr>
            <td><b>Start of Repair</b></td>
            <td align="center"> : </td>
            <td><?php echo $newdateob?></td>
          </tr>
          <tr>
            <td><b>End of Repair</b></td>
            <td align="center"> : </td>
            <td><?php echo $newendob ?></td>
          </tr>
          <tr>
            <td><b>No. of Days</b></td>
            <td align="center"> : </td>
            <td><?php echo $totaldays ?> days</td>
          </tr>
          <tr>
            <td><b>Fee</b></td>
            <td align="center"> : </td>
            <td> ₱ <?php echo number_format($fee, 2)?></td>
          </tr>
          <tr><td colspan="3"><hr style="margin-top:0px;margin-bottom:0px;"></td></tr>
          <tr>
            <td></td>
            <td align="center"><b>Total Fee : </b></td>
            <td> ₱ <?php echo number_format($totalfee, 2) ?></td>
          </tr>
        </table><br>
        <label style="padding-top:10px;background-color:#bdd5fc;width:900px;border-radius:10px"><b><h2><i class="bi bi-star-fill"></i> Ratings and Feedback</h2></b></label>
        <?php 
          while ($rows = mysqli_fetch_array($resultfeedback))
          {
            echo '<center><div style="background-color:white;border-radius:10px;width:700px;"><table class="table" style="margin-bottom:10px"><tr>';
            echo '<td rowspan="3" width="70px""><img class="img-dis" src="../profilepix/'.$profilepix.'"style="border-radius:50px;width: 80px;height: 80px;margin-top: 10px;"></td>';
            echo '<th class="text-left">'.$fname.' '.$lname.'</th>';
            echo '<th class="text-right">'.$newcreated = date('F d, Y', strtotime($rows['created'])).'</th>';
            echo '</tr>';
            echo '<tr><td colspan="3">';
            echo drawStars($rows['rate']);
            echo '</td></tr>';
            echo '<tr>';
            echo '<td colspan="3">'.$rows['feedback'].'</td>';
            echo '</tr></table></div></center>';
          }
        ?>
      </div>
  </div>
</div>
<br><br>

<?php include('../includes/footer.php'); ?>
</body>
</html>