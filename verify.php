<?php
include('includes/config.php');
	$code = $_GET['code'];

	mysqli_query($database, "UPDATE users SET status = 'Verified' WHERE code='$code'");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Verify User</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/mana.png">
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
    height: 575px;
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
    height: 575px;
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
            <a href="../index.php"><img src="images/mana.png" alt=""/></a>
            <h3>Welcome</h3>
            <a href="login.php"><input type="submit" name="" value="Login" style="background-color:#0062cc;color:white"/><br/></a>
        </div>
        <div class="col-md-8 register-right" >
        	<div align="center" style="width:885px;margin-top:20%">
				<div class="alert alert-success" role="alert">
				  <h3 class="alert-heading">Email Verified</h3>
				  <p><h5>
				  	You're all set. You can <a href="login.php">log-in</a> now.
				  </h6></p>
				</div>
			</div>
        </div>
    </div>
</div>
</body>
</html>