<?php 

  include('../includes/config.php');

  $userid = $_POST['userid'];

  $badge = mysqli_query($database, "SELECT * FROM notification WHERE notifto = '$userid' AND status=0");
  $count = mysqli_num_rows($badge);
  $color = mysqli_query($database, "SELECT * FROM notification WHERE notifto = '$userid'ORDER BY created DESC LIMIT 5");

?>
<i class="badge" style="background-color:#FF2400"><?php if(mysqli_num_rows($badge) != 0){echo $count;}else{}?></i>
<?php
?>