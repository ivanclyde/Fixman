<?php 
	
	include('../includes/config.php');

	$repairmanid = $_POST['repairmanid'];

	$messageto = mysqli_query($database, "SELECT * FROM message WHERE messto = $repairmanid AND rseen=0");
  	$messcount = mysqli_num_rows($messageto);
?>
<i class="badge" style="background-color:#FF2400"><?php if(mysqli_num_rows($messageto) != 0){echo $messcount;}else{}?></i>