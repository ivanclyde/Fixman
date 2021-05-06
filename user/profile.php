<?php
  session_start();

  if (!isset($_SESSION['userid'])) 
  {
    header('Location: index.php');
  }

  include('../includes/config.php');

  $repairmanid = $_GET['repairmanid'];
  $userid = $_SESSION['userid'];

  $result = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
  while ($row = mysqli_fetch_array($result)) 
  {
    $rfname = $row['fname'];
    $rlname = $row['lname'];
    $rage = $row['age'];
    $raddress = $row['address'];
    $rcontactno = $row['contactno'];
    $rgender = $row['gender'];
    $category = $row['category'];
    $rprofilepix = $row['profilepix'];
    $experience = $row['experience'];
    $remail = $row['email'];
    $documents = $row['documents'];
    $documents2 = $row['documents2'];
    $documents3 = $row['documents3'];
  }
  $results = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
  while ($res = mysqli_fetch_array($results)) 
  {
    $fname = $res['fname'];
    $profilepix = $res['profilepix'];
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
	  <title>Repairman Profile and Portfolio</title>
	  <meta charset="utf-8">
    <link rel="icon" href="../images/mana.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
      <script src="../repairman/fullcalendar/lib/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
      rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="user.css">
</head>
<body>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="size" value="1000000">
<?php 
  include('userheader.php');
?>

<div class="container-fluid" style="margin-top:5px;">
  <div class="row">
    <div style="background-color:#F1F1F1;height:700px;width:330px !important">
        <button class="btn btn-light"><a href="viewrepairman.php?repairmanid=<?php echo $repairmanid ?>" style="text-decoration:none;color:black"><i class="bi bi-caret-left"></i> Back</a></button>
        <center><div class="img_div">
        <img src="../profilepix/<?php echo $rprofilepix ?>" style="width:200px;height:200px;border-radius:100px">
      </div><br>
      <h3><?php echo $rfname ?> <?php echo $rlname ?></h3>
      <h6>( <?php echo$category; ?> )</h6>
      <h7><b>Rating :</b> <?php if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } ?></h7>
    </div></center>
      <div id="accordion" style="margin-left:10px;">
        <div class="card" style="width:990px;margin-bottom:10px;">
          <div class="card-header" id="headingOne" style="background-color:skyblue">
              <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <h4><b>Profile</b></h4>
              </a>
            </h5>
          </div>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
              <label><b>Fullname  </b><?php echo str_repeat('&nbsp;', 30); echo $rfname; echo '&nbsp&nbsp'; echo $rlname?></label><br>
              <label><b>Gender</b> <?php echo  str_repeat('&nbsp;', 34); echo $rgender;?></label><br>
              <label><b>Age</b> <?php echo str_repeat('&nbsp;', 40); echo $rage;?></label><br>
              <label><b>Address</b> <?php echo str_repeat('&nbsp;', 32); echo $raddress;?></label><br>
              <label><b>Contact Number</b> <?php echo str_repeat('&nbsp;', 16); echo $rcontactno;?></label><br>
              <label><b>Email</b> <?php echo str_repeat('&nbsp;', 37); echo $remail;?></label><br>
              <label><b>Experience</b> <?php echo str_repeat('&nbsp;', 27); echo $experience;?></label>
            </div>
          </div>
        </div>
        <div class="card" style="width:990px;">
          <div class="card-header" id="headingOne" style="background-color:skyblue">
              <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <h4><b>Portfolio</b></h4>
              </a>
            </h5>
          </div>
          <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
              &emsp;&emsp;&emsp;&emsp;
              <a target="_blank" href="http://localhost/fixman/supportingdocs/<?php echo$documents?>"><img src="../supportingdocs/<?php echo $documents ?>" width="200" height="200" style="border-radius:5px;"></a>
              <?php
              echo '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
              if(!empty($documents2))
                { ?>
                  <a target="_blank" href="http://localhost/fixman/supportingdocs/<?php echo$documents2?>"><img src="../supportingdocs/<?php echo $documents2 ?>" width="200" height="200" style="border-radius:5px;"></a>
          <?php }
                else { }
              echo '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
              if(!empty($documents3))
                { ?>
                  <a target="_blank" href="http://localhost/fixman/supportingdocs/<?php echo$documents3?>"><img src="../supportingdocs/<?php echo $documents3 ?>" width="200" height="200" style="border-radius:5px;"></a>
          <?php }
                else { }
              ?>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
</html>