<?php 
session_start();

  if (!isset($_SESSION['userid'])) 
  {
    header('Location: index.php');
  }

	include('../includes/config.php');

	$userid = $_SESSION['userid'];

	$users = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
	while ($use = mysqli_fetch_array($users)) 
	{
	  $fname = $use['fname'];
	  $profilepix = $use['profilepix'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Messages</title>
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
<body>
<?php include('userheader.php') ?>

<div class="container-fluid" style="margin-top:5px;">
	<div class="row">
		<div style="background-color:#F1F1F1;height:585px;width:300px !important;min-height:600px;overflow-y:auto">
			<div id="displaychatheaderhere">
				<!--- Display chatheade here --->
			</div>
		</div>
	</div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
<script type="text/javascript">
	$(function() { 
		setInterval(function() {
			var userid = '<?php echo $_SESSION['userid'];?>';
			$.ajax ({
				url:'getchat.php',
				data: 'userid=' + userid,
				type: "POST",
				success:function(res){
					$('#displaychatheaderhere').html(res);
				}
			})
		}, 500);
	})
</script>
</html>