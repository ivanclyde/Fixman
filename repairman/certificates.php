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
    $documents = $rep['documents'];
    $documents2 = $rep['documents2'];
    $documents3 = $rep['documents3'];
    $category = $rep['category'];
  }

  if(isset($_FILES['profilepix']))
  {
   $profilepix = $_FILES['profilepix']['name'];
   $target = "../profilepix/".basename($_FILES['profilepix']['name']);
   move_uploaded_file($_FILES['profilepix']['tmp_name'], $target);

   mysqli_query($database, "UPDATE repairman SET profilepix='$profilepix' WHERE repairmanid='$repairmanid'");
   echo '<script>window.location.href="certificates.php"</script>';
  }

  if(isset($_FILES['documents2']))
  {
   $documents2 = $_FILES['documents2']['name'];
   $target = "../supportingdocs/".basename($_FILES['documents2']['name']);
   move_uploaded_file($_FILES['documents2']['tmp_name'], $target);

   mysqli_query($database, "UPDATE repairman SET documents2='$documents2' WHERE repairmanid='$repairmanid'");
   echo "<script>alert('Certificate Added Successfully'); 
       window.location.href='certificates.php'</script>";
  }

  if(isset($_FILES['documents3']))
  {
   $documents3 = $_FILES['documents3']['name'];
   $target = "../supportingdocs/".basename($_FILES['documents3']['name']);
   move_uploaded_file($_FILES['documents3']['tmp_name'], $target);

   mysqli_query($database, "UPDATE repairman SET documents3='$documents3' WHERE repairmanid='$repairmanid'");
   echo "<script>alert('Certificate Added Successfully'); 
       window.location.href='certificates.php'</script>";
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
    <input type="file" id="profile" name="profilepix" accept="image/gif, image/jpeg, image/png" style="visibility:hidden;display:none" />
</form>
<form id="doc2img" action="#.php" method="post" enctype="multipart/form-data">
    <input type="file" id="docs2" name="documents2" accept="image/gif, image/jpeg, image/png" style="visibility:hidden;display:none" />
</form>
<form id="doc3img" action="#.php" method="post" enctype="multipart/form-data">
    <input type="file" id="docs3" name="documents3" accept="image/gif, image/jpeg, image/png" style="visibility:hidden;display:none" />
</form>
<?php 
	include('repairmanheader.php');
?>

<div class="container-fluid" style="margin-top:5px;">
  <div class="row">
    <div style="background-color:#F1F1F1;height:600px;width:330px !important">
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
            <a href="repairmanprofile.php" style="margin-bottom:5px;text-decoration:none;color:black">Profile</a><br>
            <a href="paymentoptions.php" style="margin-bottom:5px;text-decoration:none;color:black">Payment Options</a><br>
            <a class="btn btn-warning" href="certificates.php" style="width:210px;margin-bottom:5px;text-decoration:none;color:black"><strong>Porfolio</strong></a><br>
            <a href="ratingsandfeedback.php" style="text-decoration:none;color:black">Ratings and Feedbacks</a>
          </div>
    </div>
    <div class="col-sm-9">
      <div class="accordion" style="margin-left:-5px">
        <div class="card">
          <div class="card-header" id="headingOne" style="background-color:skyblue">
            <h5 class="mb-0">
              <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <h4><b>My Portfolio</b></h4>
              </a>
            </h5>
          </div>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
              <div class="row text-center">
                <div class="col">
                  <center><a target="_blank" href="http://localhost/fixman/supportingdocs/<?php echo$documents?>"><img src="../supportingdocs/<?php echo $documents ?>" width="250px" height="250px" style="border-radius:5px;"></a></center>
                  <hr>
                </div>
                <div class="col">
                  <?php 
                  if(empty($documents2))
                    {
                      echo '<br><br><br><br><br>';
                      echo '<label for="docs2" class="btn btn-success">Upload Certificate</label>';
                    }
                  else
                    { ?>
                      <center><a target="_blank" href="http://localhost/fixman/supportingdocs/<?php echo$documents2?>"><img src="../supportingdocs/<?php echo $documents2 ?>" width="250px" height="250px" style="border-radius:5px;"></a></center>
                  <hr>
                  <label for="docs2" class="btn btn-success">Change Certificate</label>
              <?php }
                  ?>
                </div>
                <div class="col">
                  <?php 
                  if(empty($documents3))
                    {
                      echo '<br><br><br><br><br>';
                      echo '<label for="docs3" class="btn btn-success">Upload Certificate</label>';
                    }
                  else
                    { ?>
                      <center><a target="_blank" href="http://localhost/fixman/supportingdocs/<?php echo$documents3?>"><img src="../supportingdocs/<?php echo $documents3 ?>" width="250px" height="250px" style="border-radius:5px;"></a></center>
                  <hr>
                  <label for="docs3" class="btn btn-success">Change Certificate</label>
              <?php }
                  ?>
                </div>
              </div>
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
    })
    $('#docs2').on('change', function() {
        $('#doc2img').submit();
    })
    $('#docs3').on('change', function() {
        $('#doc3img').submit();
    })
</script>
</html>