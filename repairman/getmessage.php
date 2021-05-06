<div id="formessage" style="height:475px;overflow-y: scroll;padding:15px;">
<?php

include('../includes/config.php');

$repairmanid = isset($_POST['repairmanid']) ? $_POST['repairmanid'] : "";
$messfrom = isset($_POST['messfrom']) ? $_POST['messfrom'] : "";
$chatid = isset($_POST['chatid']) ? $_POST['chatid'] : "";

$displaymessages = mysqli_query($database, "SELECT * FROM message WHERE messto = '$repairmanid' AND messfrom = '$messfrom' AND chatid = '$chatid' OR messto = '$messfrom' AND messfrom = '$repairmanid' AND chatid = '$chatid'");

	while ($messrows = mysqli_fetch_array($displaymessages)) 
	{ 
		if($messrows['messfrom'] != $repairmanid)
		{ ?>
			<div class="alert alert-info" style="margin-bottom:5px;width:max-content;height:45px;border-radius:15px;clear:both"><div class="float-left" style="margin-left:-15px;margin-top:-10px"><?php echo $messrows['content'] ?></div><br><span class="float-left" style="font-size:0.6em;margin-left:-14px;margin-top:-10px"><?php echo$newcreated = date('M d Y h:i A', strtotime($messrows['created'])) ?></span></div>
  <?php }
		else
		{ ?>
			<div class="alert alert-secondary" style="margin-bottom:5px;width:max-content;height:45px;border-radius:15px;float:right;clear:both"><div class="float-right" style="margin-right:-15px;margin-top:-10px"><?php echo $messrows['content'] ?></div><br><span class="float-right" style="font-size:0.6em;margin-right:-14px;margin-top:-10px"><?php echo$newcreated = date('M d Y h:i A', strtotime($messrows['created'])) ?></span></div>
  <?php }
	}
?>
</div>
<script type="text/javascript">
	$('#formessage').scrollTop($('#formessage')[0].scrollHeight);
</script>