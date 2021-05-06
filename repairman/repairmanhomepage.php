<?php
	session_start();

	if (!isset($_SESSION['repairmanid'])) 
	{
		header('Location: index.php');
	}

	include('../includes/config.php');

	$repairmanid = $_SESSION['repairmanid'];

	$repairman = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
	while ($rep = mysqli_fetch_array($repairman)) 
	{
	  $fname = $rep['fname'];
      $lname = $rep['lname'];
	  $profilepix = $rep['profilepix'];
	  $paymentopt = $rep['paymentopt'];
	}

	$totalbookings = mysqli_query($database, "SELECT * FROM booking WHERE repairmanid='$repairmanid' AND status='Complete'");
    $bookings = mysqli_num_rows($totalbookings);
    $days = mysqli_query($database, "SELECT sum(totaldays) AS totaldays FROM booking WHERE status = 'Complete' AND repairmanid = '$repairmanid'");
    $earnings = mysqli_query($database, "SELECT sum(totalfee) AS totalfees FROM booking WHERE status = 'Complete' AND repairmanid = '$repairmanid'");
    $getbook = mysqli_query($database,"SELECT * FROM booking WHERE repairmanid = '$repairmanid' AND status = 'Approved' OR status = 'Unpaid' OR status = 'Paid'");
    while ($boo = mysqli_fetch_array($getbook)) 
    {
        $description = $boo['description'];
        $date = date('F d, Y', strtotime($boo['dateob']));
        $time = date('h:i A', strtotime($boo['timeob']));
        $status = $boo['status'];
        $bookingid = $boo['bookingid'];
        $userid = $boo['userid'];
            $users = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
            while ($use = mysqli_fetch_array($users)) 
            {
                $ufname = $use['fname'];
                $ulname = $use['lname'];
            }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hompage</title>
	<meta charset="utf-8">
	<link rel="icon" href="../images/mana.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="fullcalendar/lib/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
     rel="stylesheet">
	<link rel="stylesheet" href="fullcalendar/fullcalendar.min.css" />
	<script src="fullcalendar/lib/moment.min.js"></script>
	<script src="fullcalendar/fullcalendar.min.js"></script>
    <link rel="stylesheet" type="text/css" href="repairman.css">
<style type="text/css">
#calendar {
    width: 600px !important;
    margin: 0 auto;
}
.success {
    background: #cdf3cd;
    padding: 10px 60px;
    border: #c3e6c3 1px solid;
    display: inline-block;
}
.response {
    height: 60px;
}

</style>
</head>
<body>
<?php include('repairmanheader.php') ?>
<div class="row">
    <div class="col-sm-2">
    	<br>
    	<div class="card text-white bg-info mb-3" style="max-width: 18rem;margin-left:10px">
		  <div class="card-header" style="text-align:center"><h4>Total Earnings</h4></div>
		  <div class="card-body" style="text-align:center">
		    <h4 class="card-title"><span><strong><?php while ($total = mysqli_fetch_array($earnings)) {echo '₱ ';echo number_format($total['totalfees'], 2);}?></strong></span></h4>
		  </div>
		</div>
		<div class="card text-white bg-info mb-3" style="max-width: 18rem;margin-left:10px">
		  <div class="card-header" style="text-align:center"><h4>Total Days Worked</h4></div>
		  <div class="card-body" style="text-align:center">
		    <h4 class="card-title"><span><strong><?php while ($total = mysqli_fetch_array($days)) {echo $total['totaldays']; echo ' days';}?></strong></span></h4>
		  </div>
		</div>
		<div class="card text-white bg-info mb-3" style="max-width: 18rem;margin-left:10px">
		  <div class="card-header" style="text-align:center"><h4>Total Bookings</h4></div>
		  <div class="card-body" style="text-align:center">
		    <h4 class="card-title"><span><strong><?php echo $bookings?></strong></span></h4>
		  </div>
		</div>
    </div>
    <div class="col-sm-7">
    	<br>
    	<center><div class="response"></div></center>
    	<div id='calendar'></div>
    </div>
    <div class="col-sm-3">
    	<br>
    	<div style="height:max-content;height:300px">
    		<hr style="margin-left:-15px">
    		<center><span><i><h4><i class="bi bi-card-checklist"></i> Reminders</h4></i></span></center>
    		<hr style="margin-left:-15px">
    		<?php 
				if($paymentopt == '0')
				{ ?>
				<div class="alert alert-danger" role="alert" style="width:290px;" align="center">
					You haven't set your payment option.<a href="paymentoptions.php" class="alert-link"> Set payment option.</a>
				</div>
		  <?php } 
          
          if(isset($status) == 'Approved' OR isset($status) == 'Unpaid' OR isset($status) == 'Paid')
            { ?>
            <div class="card border-info mb-3" style="max-width: 18rem;">
              <div class="card-header bg-transparent border-info"><b>Client Name: </b><?php echo$ufname; echo ' '; echo$ulname; ?></div>
              <div class="card-body">
                <p class="card-text" style="margin-top:-10px"><b>Description: </b><?php echo$description; ?></p>
                <p class="card-text" style="margin-top:-10px"><b>Date of Repair: </b><?php echo$date; ?></p>
                <p class="card-text" style="margin-top:-10px"><b>Time of Repair: </b><?php echo$time; ?></p>
                <?php
                if($status == 'Paid')
                    { ?>
                        <p class="card-text" style="margin-top:-10px"><b>Status: </b><?php echo"<font style='color:blue'>".$status; echo', For rating'; echo"<font style='color:black'>"; ?></p>
              <?php }
                    else
                    { ?>
                        <p class="card-text" style="margin-top:-10px"><b>Status: </b><?php echo"<font style='color:blue'>".$status; echo"<font style='color:black'>"; ?></p>
              <?php }
                ?>
              </div>
              <div class="card-footer bg-transparent border-info" style="margin-top:-20px;text-align:center">
                <?php 
                    if($status == 'Approved')
                    {
                        echo '<a href="repairmanviewbookingstep2.php?bookingid='.$bookingid.'&userid='.$userid.'"><button class="btn btn-info" >View Details</button></a>';
                    }
                    if($status == 'Unpaid')
                    {
                        echo '<a href="repairmanviewbookingstep2.php?bookingid='.$bookingid.'&userid='.$userid.'"><button class="btn btn-info" >View Details</button></a>';
                    }
                    if($status == 'Paid')
                    {
                        echo '<a href="repairmanviewbookingstep2.php?bookingid='.$bookingid.'&userid='.$userid.'"><button class="btn btn-info" >View Details</button></a>';
                    }
                }
              ?>
              </div>
            </div>
    	</div>
    </div>
</div>
<br>
<?php include('../includes/footer.php'); ?>
</body>
<script>
$(document).ready(function () {
    var repairmanid = '<?php echo $_SESSION['repairmanid'];?>';
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "fetch-event.php?repairmanid="+repairmanid,
        displayEventTime: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Title:');
            var repairmanid = '<?php echo $_SESSION['repairmanid'];?>';
            if (title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: 'add-event.php',
                    data: 'title=' + title + '&start=' + start + '&end=' + end + '&repairmanid=' + repairmanid,
                    type: "POSt",
                    success: function (data) {
                        displayMessage("Added Successfully");
                    }
                });
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            repairmanid: repairmanid,
                            allDay: allDay
                        },
                true
                        );
            }
            calendar.fullCalendar('unselect');
        },
        editable: true,
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "delete-event.php",
                    data: "&id=" + event.id,
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Deleted Successfully");
                        }
                    }
                });
            }
        }
    });
});

function displayMessage(message) {
        $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}
</script>
</html>