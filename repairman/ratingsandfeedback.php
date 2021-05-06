<?php 
  session_start();

  if (!isset($_SESSION['repairmanid'])) 
  {
    header('Location: index.php');
  }

  include('../includes/config.php');

  $repairmanid = $_SESSION['repairmanid'];

  $result = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
  while ($row = mysqli_fetch_array($result))
  {
  	$fname = $row['fname'];
  	$lname = $row['lname'];
  	$profilepix = $row['profilepix'];
    $category = $row['category'];
  }

  $resultfeedback = mysqli_query($database, "SELECT * FROM ratingsandfeedback INNER JOIN users ON ratingsandfeedback.userid=users.userid WHERE ratingsandfeedback.repairmanid = $repairmanid ORDER BY created DESC");
     function drawStars(int $starRating)
    {
      echo "<span style='color: #FFFF00;font-size:25px'>";
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

  if(isset($_FILES['profilepix']))
  {
   $profilepix = $_FILES['profilepix']['name'];
   $target = "../profilepix/".basename($_FILES['profilepix']['name']);
   move_uploaded_file($_FILES['profilepix']['tmp_name'], $target);

   mysqli_query($database, "UPDATE repairman SET profilepix='$profilepix' WHERE repairmanid='$repairmanid'");
   echo '<script>window.location.href="ratingsandfeedback.php"</script>';
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
  	<title>My Ratings and Feedback</title>
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
<style type="text/css">
	.table>tbody>tr>td,
	.table>tbody>tr>th {
	  border-top: none;
	  padding: 5px !important;
	}
	.table {
		margin-bottom:5px !important;
	}
	.sidenav {
    	height: 553px;
  	}
  .img-dis {
    width: 80px;
    height: 80px;
    margin-top: 10px;
  }
</style>
</head>
<body>
<form id="image" action="#.php" method="post" enctype="multipart/form-data">
    <input type="file" id="profile" name="profilepix" style="visibility:hidden;display:none" />
</form>
<?php include('repairmanheader.php'); ?>

<div class="container-fluid" style="margin-top:5px;">
  <div class="row">
    <div style="background-color:#F1F1F1;height:800px;width:330px !important">
          <center><div class="img_div">
            <br>
            <img src="../profilepix/<?php echo $profilepix ?>" style="width:200px;height:200px;border-radius:100px">
            <h3><?php echo $fname ?> <?php echo $lname ?></h3>
            <h6>( <?php echo$category; ?> )</h6>
            <h7><b>Rating :</b> <?php if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } ?></h7>
            <hr class="solid">
            <label for="profile" class="btn btn-success"><i class="bi bi-person-circle"></i> Change Picture</label>
          </div></center><br>
          <div style="margin-left:80px">
            <a href="repairmanprofile.php" style="margin-bottom:5px;text-decoration:none;color:black;">Profile</a><br>
            <a href="paymentoptions.php" style="margin-bottom:5px;text-decoration:none;color:black">Payment Options</a><br>
            <a href="certificates.php" style="margin-bottom:5px;text-decoration:none;color:black">Portfolio</a><br>
            <a class="btn btn-warning" href="ratingsandfeedback.php" style="width:210px;text-decoration:none;color:black"><strong>Ratings and Feedbacks</strong></a>
          </div>
    </div>
    <div class="col-sm-9">
      <div class="accordion" style="margin-left:-5px">
        <div class="card">
          <div class="card-header" id="headingOne" style="background-color:skyblue">
            <h5 class="mb-0">
              <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <h4><b>My Ratings and Feedbacks</b></h4>
              </a>
            </h5>
          </div>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
              <?php 
                  while ($rows = mysqli_fetch_array($resultfeedback))
                  {
                  echo '<div style="background-color:#f1f1f1;border-radius:10px;"><table class="table"><tr>';
                  echo '<td rowspan="3" width="70px"><img class="img-dis" src="../profilepix/'.$rows['profilepix'].'" style="border-radius:50px;margin-left:10px;margin-right:10px"></td>';
                  echo '<th class="text-left">'.$rows['fname'].' '.$rows['lname'].'</th>';
                  echo '<th class="text-right">'.$newcreated = date('F d, Y', strtotime($rows['created'])).'</th>';
                  echo '</tr>';
                  echo '<tr><td colspan="3">';
                  echo drawStars($rows['rate']);
                  echo '</td></tr>';
                  echo '<tr>';
                  echo '<td colspan="3">'.$rows['feedback'].'</td>';
                  echo '</tr></table></div>';
                  }
                ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
<script>
    $('#profile').on('change', function() {
        $('#image').submit();
    })</script>
</html>