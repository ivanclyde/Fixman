<?php 

	include('../includes/config.php');

	$userid = $_POST['userid'];

	$messageto = mysqli_query($database, "SELECT * FROM message WHERE messto = '$userid' AND useen = 0 OR messfrom = '$userid' AND useen = 0");
  	$messcount = mysqli_num_rows($messageto);
?>
<i class="badge" style="background-color:#FF2400"><?php if(mysqli_num_rows($messageto) != 0){echo $messcount;}else{}?></i>