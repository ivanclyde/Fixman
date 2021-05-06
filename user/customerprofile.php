<?php
	session_start();

	if (!isset($_SESSION['userid'])) 
	{
		header('Location: index.php');
	}

	include('../includes/config.php');

	$userid = $_SESSION['userid'];

  if(isset($_FILES['profilepix']))
  {
   $profilepix = $_FILES['profilepix']['name'];
   $target = "../profilepix/".basename($_FILES['profilepix']['name']);
   move_uploaded_file($_FILES['profilepix']['tmp_name'], $target);

   mysqli_query($database, "UPDATE users SET profilepix='$profilepix' WHERE userid='$userid'");
   echo '<script>window.location.href="customerprofile.php"</script>';
  }

	$result = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
	while ($row = mysqli_fetch_array($result)) 
	{
		  $fname = $row['fname'];
	    $mname = $row['mname'];
		  $lname = $row['lname'];
	    $age = $row['age'];
	    $bdate = $row['bdate'];
	    $newbdate = date('F d, Y', strtotime($row['bdate']));
	    $address = $row['address'];
	    $contactno = $row['contactno'];
	    $gender = $row['gender'];
	    $profilepix = $row['profilepix'];
	    $username = $row['username'];
	    $password = $row['password'];
	    $email = $row['email'];
	}

  if (isset($_POST['updateprofile'])) 
  {
    $userid = mysqli_real_escape_string($database, $_POST['userid']);
    $fname = mysqli_real_escape_string($database, $_POST['fname']);
    $mname = mysqli_real_escape_string($database, $_POST['mname']);
    $lname = mysqli_real_escape_string($database, $_POST['lname']);
    $bdate = mysqli_real_escape_string($database, $_POST['bdate']);
    $address = mysqli_real_escape_string($database, $_POST['address']);
    $contactno = mysqli_real_escape_string($database, $_POST['contactno']);
    $gender = mysqli_real_escape_string($database, $_POST['gender']);

    $fname = ucfirst($fname);
    $mname = ucfirst($mname);
    $lname = ucfirst($lname);

    
    $sql = "UPDATE users SET fname='$fname', mname='$mname', contactno='$contactno',address='$address', lname='$lname', bdate='$bdate',gender='$gender' WHERE userid='$userid'";
    mysqli_query($database, $sql);

    echo "<script>alert('Profile Updated Successfully'); window.location.href='customerprofile.php'</script>";
  }

  if (isset($_POST['updateaccount'])) 
  {

    $userid = mysqli_real_escape_string($database, $_POST['userid']);
    $username = mysqli_real_escape_string($database, $_POST['username']);
    $password = mysqli_real_escape_string($database, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($database, $_POST['confirmpassword']);
    $email = mysqli_real_escape_string($database, $_POST['email']);
 
    $sql = mysqli_query($database, "SELECT * FROM users WHERE email = '$email' OR username ='$username'");

    if($password!=$confirmpassword)
    {
      echo "<script>alert('Your password did not match!');window.location.href='customerprofile.php'</script>";
    }
    else
    {
      if(mysqli_num_rows($sql) > 0) 
      {
        echo "<script>alert('Username or Email has already been taken!');window.location.href='customerprofile.php'</script>";
      }
        else 
        {
        $sql = "UPDATE users SET username='$username', password='$password', email='$email' WHERE userid='$userid'";
        mysqli_query($database, $sql);

        echo "<script>alert('Account Updated Successfully'); window.location.href='customerprofile.php'</script>";
        }
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
	  <title>My Profile</title>
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
<style type="text/css">
  .form-control {
    width: 250px !important;
    opacity: 0.5;
  }
  .edit td {
    padding: 2px;
  }
</style>
<body>
<form id="image" action="#.php" method="post" enctype="multipart/form-data">
    <input type="file" id="profile" name="profilepix" accept="image/gif, image/jpeg, image/png" style="visibility:hidden;display:none" />
</form>
<?php 
  include('userheader.php')
?>

<div class="container-fluid" style="margin-top:5px;">
  <div class="row">
    <div style="background-color:#F1F1F1;height:585px;width:330px !important">
      <input type="hidden" name="size" value="1000000">
        <center><div class="img_div">
          <br>
          <img src="../profilepix/<?php echo $profilepix ?>" style="width:200px;height:200px;border-radius:100px">
          <hr class="solid">
          <label for="profile" class="btn btn-success"><i class="bi bi-person-circle"></i> Change Picture</label> 
          <h3><?php echo $fname ?> <?php echo $lname ?></h3>
        </div></center>
    </div>
    <div class="col-sm-8">
        <div id="accordion" style="margin-left:-5px">
          <div class="card" style="width:990px">
            <div class="card-header" id="headingOne" style="background-color:skyblue">
              <h5 class="mb-0">
                <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <h4><b>My Profile</b></h4>
                  <a class="float-right" href="#.php" data-toggle="modal" data-target="#editprofile" style="font-size:0.8em"><i class="bi bi-pencil-square"></i> Edit</a>
                </a>
              </h5>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <table>
                  <tr>
                    <td><b>First Name</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $fname;?></td>
                  </tr>
                  <tr>
                    <td><b>Middle Name</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $mname;?></td>
                  </tr>
                  <tr>
                    <td><b>Last Name</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $lname;?></td>
                  </tr>
                  <tr>
                  <tr>
                    <td><b>Birthdate</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $newbdate;?></td>
                  </tr>
                  <tr>
                    <td><b>Address</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $address;?></td>
                  </tr>
                  <tr>
                    <td><b>Contact Number</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $contactno;?></td>
                  </tr>
                  <tr>
                    <td><b>Gender</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $gender;?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="card" style="margin-top:5px;width:990px">
            <div class="card-header" id="headingTwo" style="background-color:skyblue">
              <h5 class="mb-0">
                <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <h4><b>My Account</b></h4>
                  <a class="float-right" href="#.php" data-toggle="modal" data-target="#editaccount" style="font-size:0.8em"><i class="bi bi-pencil-square"></i> Edit</a>
                </a>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                <table>
                  <tr>
                    <td><b>Username</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $username;?></td>
                  </tr>
                  <tr>
                    <td><b>Password</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><input style="border:none" type="password" value="<?php echo $password ?>" id="myInput"><i class="bi bi-eye" onclick="myFunction()"></i></td>
                  </tr>
                  <tr>
                    <td><b>Email Address</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $email;?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<!-- Edit Profile -->
<form action="#.php" method="post" enctype="multipart/form-data">
<div class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h4 class="modal-title" id="exampleModalLabel">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>Edit Profile</b></h4>
      </center>
      </div>
      <div class="modal-body">
        
        <table class="edit">
          <tr>
            <td><label><b>First Name</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="text" name="fname" value=<?php echo $fname; ?>></td>
          </tr>
          <tr>
            <td><label><b>Middle Name</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="text" name="mname" value=<?php echo $mname; ?>></td>
          </tr>
          <tr>
            <td><label><b>Last Name</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="text" name="lname" value=<?php echo $lname; ?>></td>
          </tr>
          <tr>
            <td><label><b>Birthdate</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="date" name="bdate" value=<?php echo $bdate;?>></td>
          </tr>
          <tr>
            <td><label><b>Address</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="text" name="address" value="<?php echo $address; ?>" /></td>
          </tr>
          <tr>
            <td><label><b>Contact Number</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="text" name="contactno" value=<?php echo $contactno; ?>></td>
          </tr>
          <tr>
            <td><label><b>Gender</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input type="radio" name="gender" value="Male" <?= $gender == 'Male' ? 'checked' : '' ?>> MALE &nbsp&nbsp<input type="radio" name="gender" value="Female" <?= $gender == 'Female' ? 'checked' : '' ?>> FEMALE</td>
          </tr>
          <tr>
            <td><input type="hidden" name="userid" value=<?php echo $userid; ?>></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><br></td>
          </tr>
        </table>
      <div class="modal-footer">
        <button class="btn btn-success" type="submit" name="updateprofile">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
</div>
</form>
<!-- Edit Account -->
<form action="#.php" method="post" enctype="multipart/form-data">
<div class="modal fade" id="editaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h4 class="modal-title" id="exampleModalLabel">&emsp;&emsp;&emsp;&emsp;&nbsp&nbsp<b>Edit Account Settings</b></h4>
      </center>
      </div>
      <div class="modal-body">
        <table class="edit">
          <tr>
            <td><label><b>Username</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="text" name="username" value=<?php echo $username; ?>></td>
          </tr>
          <tr>
            <td><label><b>Password</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input id="myInputpassword1" class="form-control" type="password" name="password" required="required"></td>
          </tr>
          <tr>
            <td><label><b>Retype Password</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="password" name="confirmpassword" required="required"></td>
          </tr>
          <tr>
            <td><label><b>Email</b></label></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><input class="form-control" type="text" name="email" value=<?php echo $email; ?>></td>
          </tr>
          <tr>
            <td><input type="hidden" name="userid" value=<?php echo $userid; ?>></td>
            <td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
          </tr>
        </table>
      <div class="modal-footer">
        <button class="btn btn-success" type="submit" name="updateaccount">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
</div>
</form>

</body>
<script type="text/javascript">
    $('#profile').on('change', function() {
        $('#image').submit();
    })

  function myFunction() 
  {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>
</html>