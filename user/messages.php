<?php 
session_start();

  if (!isset($_SESSION['userid'])) 
  {
    header('Location: index.php');
  }

	include('../includes/config.php');

	$userid = $_SESSION['userid'];
	$chatid = $_GET['chatid'];
	$messfrom = $_GET['from'];

	if (isset($_GET['from']))
	{
		mysqli_query($database, "UPDATE message SET useen='1' WHERE messto = '$userid' AND messfrom = '$messfrom' OR messto = '$messfrom' AND messfrom = '$userid'");
	}

	if(isset($_POST['delete']))
	{
		mysqli_query($database, "DELETE FROM message WHERE messto = '$userid' AND messfrom = '$messfrom' OR messto = '$messfrom' AND messfrom = '$userid'");
		echo '<script>alert("Conversation Deleted"); window.location.href="message.php"</script>';
	}

	$users = mysqli_query($database, "SELECT * FROM users WHERE userid = '$userid'");
	while ($use = mysqli_fetch_array($users)) 
	{
	  $fname = $use['fname'];
	  $profilepix = $use['profilepix'];
	}

	$repairman = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$messfrom'");
	while($rep = mysqli_fetch_array($repairman))
	{
		$rfname = $rep['fname'];
		$rlname = $rep['lname'];
		$category = $rep['category'];
		$rprofilepix = $rep['profilepix'];
	}

	if(isset($_POST['sendmessage'])) 
	{
		date_default_timezone_set('Asia/Manila');
		$content = mysqli_real_escape_string($database, $_POST['message']);
		$messfrom = mysqli_real_escape_string($database, $_SESSION['userid']);
		$messto = mysqli_real_escape_string($database, $_GET['from']);
		$chatid = mysqli_real_escape_string($database, $_GET['chatid']);

		mysqli_query($database,"INSERT INTO message (messto, messfrom, content, created, useen,rseen, chatid) VALUES ('$messto','$messfrom','$content',CURRENT_TIMESTAMP,'1','0', '$chatid')");
		header("Refresh:0");
	}

	$display = mysqli_query($database, "SELECT * FROM message WHERE messto = '$userid' OR messfrom = '$userid' GROUP BY messfrom AND messto ORDER BY created ASC");

	$rating = mysqli_query($database, "SELECT sum(rate) AS rate FROM ratingsandfeedback WHERE repairmanid = '$messfrom'");
	$rates =mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE repairmanid = '$messfrom'");
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
<?php include('userheader.php') ?>

<div class="container-fluid" style="margin-top:5px;">
	<div class="row">
		<div style="background-color:#F1F1F1;width:300px !important;min-height:600px;overflow-y:auto">
			<div id="displaychatheaderhere">
				<!--- Display chatheader here --->
			</div>
		</div>
		<div id="displaymessages" style="margin-left:5px;background-color:#F7FAFF;width:730px;">
			<div id="dismessages">
				<!---- Display messages here ----->
			</div>
			<hr>
			<div id="chatbox">
			   <form action="#.php" method="post" enctype="multipart/form-data">
			   	<input type="hidden" name="inputchatid" value=<?php echo$chatid ?>>
				<input class="message" type="text" name="message" style="border-radius:50px;height:40px;width:550px;margin-left:90px" placeholder="Type a message">
				<label for="send"><i  class="bi bi-pencil-square" style="font-size:20px;cursor:pointer"></i></label>
				<input id="send" type="submit" name="sendmessage" style="visibility:hidden">
			   </form>
			</div>
		</div>

		<div class="text-center" id="profile" style="margin-left:5px;background-color:#F7FAFF;width:305px">
			<br>
			<img src="../profilepix/<?php echo$rprofilepix ?>" style="width:100px;height:100px;border-radius:100px"><br><br>
			<div style="font-size:1.3em"><?php echo$rfname ?> <?php echo$rlname?></div>
			<h6>( <?php echo$category; ?> )</h6>
			<h7><b>Rating :</b> <?php if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } ?></h7>
			<br>
			<a href="profile.php?repairmanid=<?php echo$messfrom ?>"><button class="btn btn-success" style="width:100px">Profile</button></a>
		  <form action="#.php" method="post" enctype="multipart/form-data" style="display:inline">
			<button class="btn btn-danger" type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this conversation?');" style="width:100px">Delete</button>
		  </form>
		</div>
	</div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
<script type="text/javascript">
	$(function() { 
		setInterval(function() {
			var userid = '<?php echo $_SESSION['userid'];?>';
			var messfrom = '<?php echo $_GET['from'];?>';
			var chatid = '<?php echo $_GET['chatid'];?>';
			$.ajax ({
				url:'getmessage.php',
				data: 'userid=' + userid + '&messfrom=' + messfrom + '&chatid=' + chatid,
				type: "POST",
				success:function(res){
					$('#dismessages').html(res);
				}
			})
		}, 500);
	})

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