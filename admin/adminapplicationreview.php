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
        $mname = $rep['mname'];
        $lname = $rep['lname'];
        $age = $rep['age'];
        $newbdate = date('F d, Y', strtotime($rep['bdate']));
        $address = $rep['address'];
        $contactno = $rep['contactno'];
        $gender = $rep['gender'];
        $profilepix = $rep['profilepix'];
        $category = $rep['category'];
        $email = $rep['email'];
        $documents = $rep['documents'];
    }

  if (isset($_POST['approve']))
  {
    mysqli_query($database, "UPDATE repairman SET status='Approved' WHERE repairmanid='$repairmanid'");

    $to = $email;

    $subject = 'Repairman Application';
    $message = 'Thank you for applying as '.$category.' to our team.<br> Your application has been approved and  your supporting documents has passed our qualifications.<br><br><a href="http://localhost/fixman/login.php">Click here to Login</a>';
    $headers = "From: FIX-MAN TEAM \r\n";
    $headers .= "MINE-Version: 1.0" ."\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);

    echo "<script>alert('Application Approved'); window.location.href='adminviewrepairmanprofile.php?repairmanid=$repairmanid';</script>";
  }

  if (isset($_POST['decline']))
  {
    mysqli_query($database, "UPDATE repairman SET status='Denied' WHERE repairmanid='$repairmanid'");

    $to = $email;

    $subject = 'Repairman Application';
    $message = 'Thank you for applying as '.$category.' to our team.<br> Your application did not qualify to our qualifications.Please submit a more reliable supporting documents.';
    $headers = "From: FIX-MAN TEAM \r\n";
    $headers .= "MINE-Version: 1.0" ."\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);

    echo "<script>alert('Application Declined'); window.location.href='adminviewapplications.php';</script>";
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Application Review</title>
		  <meta charset="utf-8">
      <link rel="icon" href="../images/fixmanlogo.png">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style type="text/css" rel="stylesheet">
body {
    font-family: Century Gothic, Arial, sans-serif, !important;
    height: auto; 
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    font-size: 1.5em !important;
}
</style>
</head>
<body>
<?php include('adminheader.php')?>

<div class="row" style="margin-top:-15px">
  <div class="col-sm-3" style="width:300px !important;background-color:#F1F1F1;height:640px">
    <button class="btn btn-light" onclick="location.href='adminviewapplications.php';"/><span class="glyphicon glyphicon-chevron-left">&nbsp</span>Back</button>
      <center><div class="img_div">
          <br>
          <img src="../profilepix/<?php echo $profilepix ?>" style="width:200px;height:200px;border-radius:100px">
          <h3><?php echo $fname ?> <?php echo $lname ?></h3>
          <h6>( <?php echo$category; ?> )</h6>
          <form action="#.php" method="post" enctype="multipart/form-data">
          <button class="btn btn-success" type="submit" name="approve" style="width:90px" onclick="return confirm('Approve Application?');">Approve</button>&nbsp&nbsp<button class="btn btn-danger" type="submit" name="decline" style="width:90px" onclick="return confirm('Decline Application?');">Decline</button>
          </form>
        </div></center>
  </div>
  <div class="col-sm-9">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-info">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <p role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="collapseOne"></p>
                  <h4><b>Repairman Application</b></h4>
                </a>
              </h4>
            </div>
            <div align="left" id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <table>
                  <tr>
                    <td><b>First Name</b></td>
                    <td> : </td>
                    <td><?php echo $fname?></td>
                  </tr>
                  <tr>
                    <td><b>Middle Name</b></td>
                    <td> : </td>
                    <td><?php echo $mname?></td>
                  </tr>
                  <tr>
                    <td><b>Last Name</b></td>
                    <td> : </td>
                    <td><?php echo $lname?></td>
                  </tr>
                  <tr>
                    <td><b>Age</b></td>
                    <td> : </td>
                    <td><?php echo $age?></td>
                  </tr>
                  <tr>
                    <td><b>Birthdate</b></td>
                    <td> : </td>
                    <td><?php echo $newbdate?></td>
                  </tr>
                  <tr>
                    <td><b>Address</b></td>
                    <td> : </td>
                    <td><?php echo $address?></td>
                  </tr>
                  <tr>
                    <td><b>Contact Number</b></td>
                    <td> : </td>
                    <td><?php echo $contactno?></td>
                  </tr>
                  <tr>
                    <td><b>Gender</b></td>
                    <td> : </td>
                    <td><?php echo $gender?></td>
                  </tr>
                  <tr>
                    <td><b>Email Address</b></td>
                    <td> : </td>
                    <td><?php echo $email?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <br>
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-info">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <p role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="true" aria-controls="collapseOne"></p>
                  <h4><b>Supprting Documents</b></h4>
                </a>
              </h4>
            </div>
            <div align="left" id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <a target="_blank" href="http://localhost/fixman/supportingdocs/<?php echo$documents?>">
                <img src="../supportingdocs/<?php echo$documents; ?>" style="width:200px;height:200px">
              </div>
            </div>
          </div>
      </div>
</div>

</body>
</html>