 <?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../config.php');

	  $user = $_SESSION['userid'];
		$repairmanid = $_GET['repairmanid'];

		$repairman = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
    while ($rep = mysqli_fetch_array($repairman)) 
    {
        $fname = $rep['fname'];
        $lname = $rep['lname'];
        $profilepix = $rep['profilepix'];
    }
    
    $booking = mysqli_query($database, "SELECT * FROM booking WHERE repairmanid='$repairmanid' AND status ='Complete'");

    $totalbookings = mysqli_query($database, "SELECT * FROM booking WHERE repairmanid='$repairmanid' AND status='Complete'");
    $bookings = mysqli_num_rows($totalbookings);

    $days = mysqli_query($database, "SELECT sum(totaldays) AS totaldays FROM booking WHERE repairmanid = '$repairmanid'");
    $earnings = mysqli_query($database, "SELECT sum(totalfee) AS totalfees FROM booking WHERE repairmanid = '$repairmanid'");

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
		  <meta charset="utf-8">
      <link rel="icon" href="../images/fixmanlogo.png">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style type="text/css">
body {
  font-family: Century Gothic, Arial, sans-serif, !important;
  height: auto; 
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  font-size: 1.5em !important;
}
.table>tbody>tr>td,
.table>tbody>tr>th {
    border-top: none;
    padding: 5px !important;
}
</style>
</head>
<body>
<?php include('adminheader.php')?>
<div class="row" style="margin-top:-15px">
  <div class="col-sm-3" style="width:300px !important;background-color:#F1F1F1;height:780px">
    <button class="btn btn-light" onclick="location.href='adminviewrepairman.php';"/><span class="glyphicon glyphicon-chevron-left">&nbsp</span>Back</button>
      <center><div class="img_div">
          <br>
          <img src="../profilepix/<?php echo $profilepix ?>" style="width:200px;height:200px;border-radius:100px">
          <h3><?php echo $fname ?> <?php echo $lname ?></h3>
          <a class="btn btn-info" href="adminviewrepairmanprofile.php?repairmanid=<?php echo$repairmanid ?>" style="width:150px;margin-bottom:5px">Profile</a>
          <a class="btn btn-warning" href="repairmanbookings.php?repairmanid=<?php echo$repairmanid ?>" style="width:150px;margin-bottom:5px">Bookings</a>
          <a class="btn btn-info" href="repairmanactivitylog.php?repairmanid=<?php echo$repairmanid ?>" style="width:150px;margin-bottom:5px">Activity Log</a>
        </div></center>
  </div>
  <div class="col-sm-3">
    <div class="panel panel-primary" style="width:280px;">
      <div class="panel-heading" align="center"><h4><b>Total Earnings</b></h4></div>
        <div class="panel-body" style="text-align:center;font-size:3em">
          <span><strong><?php while ($total = mysqli_fetch_array($earnings)) {echo '₱ ';echo number_format($total['totalfees'], 2);}?></strong></span>
        </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="panel panel-primary" style="width:200px;">
      <div class="panel-heading" align="center"><h4><b>Total Days Worked</b></h4></div>
        <div class="panel-body" style="text-align:center;font-size:3em">
          <span><strong><?php while ($total = mysqli_fetch_array($days)) {echo $total['totaldays'].' days';}?></strong></span>
        </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="panel panel-primary" style="width:200px;">
      <div class="panel-heading" align="center"><h4><b>Total Bookings</b></h4></div>
        <div class="panel-body" style="text-align:center;font-size:3em">
          <span><strong><?php echo $bookings?></strong></span>
        </div>
    </div>
  </div>
  <div class="col-sm-9">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-info">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <p role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="collapseOne"></p>
                  <h4><b>Bookings</b></h4>
                </a>
              </h4>
            </div>
            <div align="left" id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="text-align:center;width:100px">Booked By</th>
                      <th style="text-align:center;width:100px">Start Date</th>
                      <th style="text-align:center;width:100px">End Date</th>
                      <th style="text-align:center;width:100px">Duration</th>
                      <th style="text-align:center;width:100px">Fee</th>
                      <th style="text-align:center;width:100px">Status</th>
                      <th style="text-align:center;width:100px">Total Fee</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      while ($book = mysqli_fetch_array($booking))
                      {
                          echo '<tr>';
                          echo '<td>'.$book['userid'].'</td>';
                          echo '<td>'.$newbdate = date('F d, Y', strtotime($book['dateob']));'</td>';
                          echo '<td>'.$newbdate = date('F d, Y', strtotime($book['endob']));'</td>';
                          echo '<td>'.$book['totaldays'].' days</td>';
                          echo '<td>₱ '.$book['fee'].'</td>';
                          echo '<td>'.$book['status'].'</td>';
                          echo '<td> ₱'.$book['totalfee'].'</td>';
                          echo '</tr>';
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
  </div>
</div>

</body>
</html>
