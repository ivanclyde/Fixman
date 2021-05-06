<?php 
session_start();

  if (!isset($_SESSION['repairmanid'])) 
  {
    header('Location: index.php');
  }

	include('../includes/config.php');

	$repairmanid = $_SESSION['repairmanid'];
	$messfrom = $_GET['messfrom'];
	$chatid = $_GET['chatid'];

	if (isset($_GET['messfrom']))
	{
		mysqli_query($database, "UPDATE message SET rseen='1' WHERE messto = '$repairmanid' AND messfrom = '$messfrom' OR messto = '$messfrom' AND messfrom = '$repairmanid'");
	}

	if(isset($_POST['delete']))
	{
		mysqli_query($database, "DELETE FROM message WHERE messto = '$repairmanid' AND messfrom = '$messfrom' OR messto = '$messfrom' AND messfrom = '$repairmanid'");
		echo '<script>alert("Conversation Deleted"); window.location.href="message.php"</script>';
	}

	$repairman = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$repairmanid'");
	while ($rep = mysqli_fetch_array($repairman)) 
	{
	  $fname = $rep['fname'];
	  $profilepix = $rep['profilepix'];
	  $paymentopt = $rep['paymentopt'];
	}
	$user = mysqli_query($database, "SELECT * FROM users WHERE userid = '$messfrom'");
	while($use = mysqli_fetch_array($user))
	{
		$ufname = $use['fname'];
		$ulname = $use['lname'];
		$uprofilepix = $use['profilepix'];
	}

	if(isset($_POST['sendmessage'])) 
	{
		date_default_timezone_set('Asia/Manila');
		$content = mysqli_real_escape_string($database, $_POST['message']);
		$messfrom = mysqli_real_escape_string($database, $_SESSION['repairmanid']);
		$messto = mysqli_real_escape_string($database, $_GET['messfrom']);
		$chatid = mysqli_real_escape_string($database, $_GET['chatid']);

		mysqli_query($database,"INSERT INTO message (messto, messfrom, content, created, rseen,useen, chatid) VALUES ('$messto','$messfrom','$content',CURRENT_TIMESTAMP,'1','0','$chatid')");
		header("Refresh:0");
	}

	$display = mysqli_query($database, "SELECT * FROM message WHERE messto = '$repairmanid' GROUP BY messfrom ORDER BY created ASC")

?>
<!DOCTYPE html>
<html>
<head>
	<title>My Messages</title>
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
.message:focus {
	outline:none;
}
::-webkit-scrollbar {
  width: 10px;
}
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
::-webkit-scrollbar-thumb {
  background: grey; 
  border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
  background: #f1f1f1; 
}
</style>
</head>
<body>
<?php include('repairmanheader.php') ?>

<div class="container-fluid" style="margin-top:5px;">
	<div class="row">
		<div style="background-color:#F1F1F1;width:300px !important">
			<div id="dischathead" style="display:block">
				<!--- Display Chatname Here---->
			</div>
		</div>
		<div id="displaymessages" style="margin-left:5px;background-color:#F7FAFF;width:730px;">
			<div id="dismessages">
				<!--- Display Message Here --->
			</div>
			<hr>
			<div id="chatbox">
			   <form id="sendmessage" action="#.php" method="post" enctype="multipart/form-data">
			   	<input type="hidden" name="inputchatid" value=<?php echo$chatid ?>>
				<input id="typemessage" class="message" type="text" name="message" style="border-radius:50px;height:40px;width:550px;margin-left:90px" required="required" placeholder="Type a message">
				<label for="send"><i  class="bi bi-pencil-square" style="font-size:20px;cursor:pointer"></i></label>
				<input id="send" type="submit" name="sendmessage" style="visibility:hidden">
			   </form>
			</div>
		</div>

		<div class="text-center" id="profile" style="margin-left:5px;background-color:#F7FAFF;width:305px">
		  <form action="#.php" method="post" enctype="multipart/form-data">
			<br>
			<img src="../profilepix/<?php echo$uprofilepix ?>" style="width:100px;height:100px;border-radius:100px"><br><br>
			<div style="font-size:1.3em"><?php echo$ufname ?> <?php echo$ulname?></div><br>
			<button class="btn btn-danger" type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this conversation?');">Delete Conversation</button>
		  </form>
		</div>
	</div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
<script type="text/javascript">
$('#dismessages').scrollTop($('#dismessages')[0].scrollHeight);
	$(function() { 
		setInterval(function() {
			var repairmanid = '<?php echo $_SESSION['repairmanid'];?>';
			var messfrom = '<?php echo $_GET['messfrom'];?>';
			var chatid = '<?php echo $_GET['chatid'];?>';
			$.ajax ({
				url:'getmessage.php',
				data: 'repairmanid=' + repairmanid + '&messfrom=' + messfrom + '&chatid=' + chatid,
				type: "POST",
				success:function(res){
					$('#dismessages').html(res);
				}
			})
		}, 500);
	})

	$(function() { 
		setInterval(function() {
			var repairmanid = '<?php echo $_SESSION['repairmanid'];?>';
			$.ajax ({
				url:'getchat.php',
				data: 'repairmanid=' + repairmanid,
				type: "POST",
				success:function(res){
					$('#dischathead').html(res);
				}
			})
		}, 500);
	})
</script>
</html>