<?php
    
    session_start();

    if (!isset($_SESSION['username'])) 
    {
        
    }
    else
    {
        if ($_SESSION['user_type'] == 'Admin') 
        {
            header("Location: adminhomepage.php");
        }
        elseif ($_SESSION['user_type'] == 'Customer') 
        {
            header("Location: customerhomepage.php");
        }
        elseif ($_SESSION['user_type'] == 'Repairman') 
        {
            header("Location: repairmanhomepage.php");
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>FIX-MAN Homepage</title>
	<link rel="icon" href="../images/fixmanlogo.png">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Numans');
html,body{
	background-size: cover;
	background-repeat: no-repeat;
	height: 100%;
	font-family: Century Gothic, Arial, sans-serif;
}
.card {
	height: 400px;
	margin-top: 50px;
	margin-bottom: auto;
	width: 400px;
	opacity: 0.9;
	background-color: #f1f1f1 !important;
}
.social_icon span{
	font-size: 60px;
	margin-left: 10px;
	color: #FFC312;
}
.social_icon span:hover{
	color: white;
	cursor: pointer;
}
.card-header h3{
	color: white;
}
.social_icon{
	position: absolute;
	right: 20px;
	top: -45px;
}
.input-group-prepend span{
	width: 50px;
	background-color: #FFC312;
	color: black;
	border:0 !important;
}
input:focus{
	outline: 0 0 0 0  !important;
	box-shadow: 0 0 0 0 !important;
}
.remember{
	color: white;
}
.remember input {
	width: 20px;
	height: 20px;
	margin-left: 15px;
	margin-right: 5px;
}
.login_btn{
	color: black;
	background-color: #FFC312;
	width: 100px;
}
.login_btn:hover{
	color: black;
	background-color: #FDD017;
}
.links{
	color: white;
}
.links a{
	margin-left: 4px;
}
tr.top td {
	border-left: 2px solid;
	border-right: 2px solid;
	border-top: 2px solid;
}	
tr.bot td {
	border-left: 2px solid;
	border-right: 2px solid;
	border-bottom: 2px solid;
}
.modal-header {
	background: -webkit-linear-gradient(left, #35D6ED, blue);
}
.background {
	height: 600px;
	background-image:url('images/background-image2.jfif');
	-webkit-background-size: cover;
	-o-background-size: cover;
    background-size: cover;
}
</style>
</head>
<body>
<?php include('includes/header.php') ?>
<div class="background">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header" align="center">
				<a href="index.php"><img src="images/mana.png" width="100px" height="100px"></a>
			</div>
			<div class="card-body">
				<form id="login-form" class="form" action="loginprocess.php" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" name="username" id="username" placeholder="Username">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" name="password" id="password" placeholder="Password">
					</div>
					<div class="form-group">
						<input type="Submit" name="submit" value="Login" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links" style="color:black">
					Don't have an account?<a href="#.php" data-toggle="modal" data-target="#register">Register</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="forgotpassword.php">Forgot your password?</a>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        	<h4 class="modal-title" id="exampleModalLabel">&emsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>Register</b></h4>
      </div>
      <div class="modal-body">
      	<div align="center">
      		<table>
      			<tr>
      				<td>
      					<table width="130px">
      						<tr class="top" align="center"><td><h5>Client</td></tr>
      						<tr class="bot" align="center"><td><a href="register/client.php"><img src="images/client.png" width="100px" height="100px"></a></td></tr>
      					</table>
      				</td>
      				<td>
      					<table><td width="50"></td></table>
      				</td>
      				<td>
      					<table width="130px">
      						<tr class="top" align="center"><td><h5>Repairman</td></tr>
      						<tr class="bot" align="center"><td><a href="register/repairman.php"><img src="images/repairman.png" width="100px" height="100px"></a></td></tr>
      					</table>
      				</td>
      			</tr>
      		</table>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php include('includes/indexfooter.php') ?>
</body>
</html>