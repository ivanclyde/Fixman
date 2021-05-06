<?php
include('../config.php');

function make_avatar($character)
{
    $path = "../profilepix/". time() . ".png";
    $image = imagecreate(200, 200);
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
    imagecolorallocate($image, $red, $green, $blue);  
    $textcolor = imagecolorallocate($image, 255,255,255);  

    imagettftext($image, 100, 0, 55, 150, $textcolor, '../fonts/arial.ttf', $character);  
    imagepng($image, $path);
    imagedestroy($image);
    return $path;
}

if (isset($_POST['submit'])) 
{
  $target = "../supportingdocs/".basename($_FILES['documents']['name']);

  $fname = mysqli_real_escape_string($database, $_POST['fname']);
  $mname = mysqli_real_escape_string($database, $_POST['mname']);
  $lname = mysqli_real_escape_string($database, $_POST['lname']);
  $bdate = mysqli_real_escape_string($database, $_POST['bdate']);
  $address = mysqli_real_escape_string($database, $_POST['address']);
  $contactno = mysqli_real_escape_string($database, $_POST['contactno']);
  $gender = mysqli_real_escape_string($database, $_POST['gender']);
  $username = mysqli_real_escape_string($database, $_POST['username']);
  $password = mysqli_real_escape_string($database, $_POST['password']);
  $confirmpassword = mysqli_real_escape_string($database, $_POST['confirmpassword']);
  $email = mysqli_real_escape_string($database, $_POST['email']);
  $category = mysqli_real_escape_string($database, $_POST['category']);
  $experience = mysqli_real_escape_string($database, $_POST['experience']);
  $documents = $_FILES['documents']['name'];
  $user_type = "Repairman";

  $today = date("d-m-Y");
  $diff = date_diff(date_create($bdate), date_create($today));
  $age = $diff->format('%y');

  $profilepix = make_avatar(strtoupper($fname[0]),($lname[0]));

  $fname = ucfirst($fname);
  $mname = ucfirst($mname);
  $lname = ucfirst($lname);
  
  move_uploaded_file($_FILES['documents']['tmp_name'], $target);

  $sqlemail = mysqli_query($database, "SELECT * FROM users WHERE email = '$email'");
  $sqlusername = mysqli_query($database, "SELECT * FROM users WHERE username = '$username'");
  $sqlrepairuser = mysqli_query($database, "SELECT * FROM repairman WHERE username = '$username'");

  if($password!=$confirmpassword)
  {
    echo "<script>alert('Your password did not match!');windowlocation.href='registerasrepairman.php'</script>";
  }
  else
  {
  if(mysqli_num_rows($sqlemail) > 0) 
    {
      $email_error = "Email already taken";
    }
      else
      {
        if(mysqli_num_rows($sqlusername) > 0) 
        {
          $name_error = "Username already taken";
        } 
        else 
        {
          if(mysqli_num_rows($sqlrepairuser) > 0)
          {
            $name_error = "Username already taken";
          }
          else 
          {
          $display = "INSERT INTO repairman(fname, mname, lname, age, bdate, address, contactno, gender, username, password, email, category, experience, documents, profilepix, user_type, status) values('$fname','$mname','$lname','$age','$bdate','$address','$contactno','$gender','$username','$password','$email','$category','$experience','$documents','$profilepix','$user_type','Pending')";
          $dis = mysqli_query($database, $display);

          echo "<script>alert('Application Submitted Successfully, Please check your email for update...'); window.location.href='../login.php'</script>";
          }
        }
      }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register as Client</title>
    <meta charset="utf-8">
    <link rel="icon" href="../images/mana.png">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
      rel="stylesheet">
<style type="text/css">
  body {
    font-family: 'Poppins', sans-serif !important;
    font-size: 1em !important;
}
.register{
    background: -webkit-linear-gradient(left, #35D6ED, blue);
    margin-left:0px;
    overflow-y: hidden;
    overflow-x: hidden;
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
    height: auto;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #F1F1F1;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #f8f9fa;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 200px;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}
</style>
</head>
<body>
<div class="register">
    <div class="row">
        <div class="col-md-4 register-left">
            <a href="../index.php"><img src="../images/mana.png" alt=""/></a>
            <h3>Welcome</h3>
            <a href="../login.php"><input type="submit" name="" value="Login"/ style="background-color:#0062cc;color:white"><br/></a>
        </div>
        <div class="col-md-8 register-right" >
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="repairman.php" role="tab" aria-controls="profile" aria-selected="false">Repairman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="client.php" role="tab" aria-controls="home" aria-selected="true">Client</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
            <form action="#.php" method="post" enctype="multipart/form-data">
                <div class="tab-pane fade show active" id="client" role="tabpanel" aria-labelledby="home-tab">
                    <h3 class="register-heading">Apply as  Repairman</h3>
                    <div class="row register-form">
                        <h3><b>Personal Info</b></h3>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                              <label for="inputfname"><b>First name</b></label>
                              <input type="text" name="fname" class="form-control" id="inputfname" required="required" placeholder="First name" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : '' ?>" />
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputmname"><b>Middle name</b></label>
                              <input type="text" name="mname" class="form-control" id="inputmname" required="required" placeholder="Middle name" value="<?php echo isset($_POST['mname']) ? $_POST['mname'] : '' ?>" />
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputlname"><b>Last name</b></label>
                              <input type="text" name="lname" class="form-control" id="inputlname" required="required" placeholder="Last name" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : '' ?>" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                              <label for="inputcontactnumber"><b>Contact Number</b></label>
                              <input type="text" name="contactno" class="form-control" id="inputcontactnumber" required="required" placeholder="+63++ ++++ ++++" maxlength="13" value="<?php echo isset($_POST['contactno']) ? $_POST['contactno'] : '' ?>" />
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputaddress"><b>Address</b></label>
                              <input type="text" name="address" class="form-control" id="inputaddress" required="required" placeholder="Address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : '' ?>" />
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputbdate"><b>Birthday</b></label>
                              <input type="date" name="bdate" class="form-control" id="inputbdate" required="required" placeholder="Address" value="<?php echo isset($_POST['bdate']) ? $_POST['bdate'] : '' ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputgender"><b>Gender</b></label>&emsp;&emsp;
                             <td><input type="radio" name="gender" id="inputgender" value="Male" required="required">&emsp;MALE &emsp;&emsp;<input type="radio" name="gender" id="inputgender" value="Female" required="required">&emsp;FEMALE<br>
                        </div>
                        <span><h3><b>Account Details</b></h3>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                              <label for="inputusername"><b>Username</b></label>
                              <div <?php if (isset($name_error)): ?> class="form_error" <?php endif ?> >
                              <input type="text" name="username" class="form-control" id="inputusername" required="required" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" />
                              <?php if (isset($name_error)): ?>
                                  <span style="color:red">*<?php echo $name_error; ?>*</span>
                              <?php endif ?>
                              </div>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputpassword"><b>Password</b></label>
                              <input type="password" name="password" class="form-control" id="inputpassword" required="required" placeholder="Password">
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputlname"><b>Retype Password</b></label>
                              <input type="password" name="confirmpassword" class="form-control" id="inputlname" required="required" placeholder="Retype password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputemail"><b>Email</b></label>
                            <div <?php if (isset($email_error)): ?> class="form_error" <?php endif ?>>
                            <input type="text" style="width:230px" name="email" class="form-control" id="inputemail" required="required" placeholder="example@mail.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" />
                              <?php if (isset($email_error)): ?>
                                <span style="color:red"><?php echo $email_error; ?></span>
                              <?php endif ?>
                            </div>
                        </div>
                        <span><h3><b>Application</b></h3>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="inputcategory"><b>Category</b></label>
                            <select class="form-control" name="category" required="required" id="inputcategory" placeholder="Category">
                                <option style="display:none" disabled selected>Choose Category</option>
                                <option value="Carpenter">Carpenter</option>
                                <option value="Electrician">Electrician</option>
                                <option value="Mechanic">Mechanic</option>
                                <option value="Plumber">Plumber</option>
                                <option value="Technician">Technician</option>
                            </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="inputexperience"><b>Experience</b></label>
                            <select class="form-control" name="experience" required="required" id="inputexperience">
                                <option style="display:none" disabled selected>Experience</option>
                                <option value="0 - 5 years">0 - 5 years</option>
                                <option value="6 - 10 years">6 - 10 years</option>
                                <option value="11- 15 years">11- 15 years</option>
                                <option value="16 - 20 years">16 - 20 years</option>
                                <option value="21 years above">21 years above</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="inputdocuments"><b>Supporting Documents</b></label>
                            <input type="file" name="documents" class="form-control" id="inputdocuments" required="required" accept="image/gif, image/jpeg, image/png">
                          </div>
                        </div>
                        <input type="submit" name="submit" class="btnRegister"  value="Register"/ style="width:200px;height:50px">
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>