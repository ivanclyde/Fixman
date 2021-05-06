<?php 

include('../includes/config.php');

$userid = $_POST['userid'];

$display = mysqli_query($database, "SELECT * FROM message WHERE messto = '$userid' OR messfrom = '$userid' GROUP BY chatid ORDER BY id DESC");
/*$status = mysqli_query($database, "SELECT * FROM message WHERE id = (SELECT max(id)FROM message) AND messto = '$userid' OR id = (SELECT max(id)FROM message) AND messfrom = '$userid' GROUP BY chatid");
while ($stat = mysqli_fetch_array($status))
{
	$useen = $stat['useen'];
}*/
					if (mysqli_num_rows($display) == 0)
					{
						echo '<center><div class="alert alert-danger" role="alert" style="width:auto;border-radius:5px;margin-bottom:3px;margin-right:5px;margin-left:5px;margin-top:5px">';
		                echo 'No Messages <i class="bi bi-emoji-frown"></i>';
		                echo '</div></center>';
					}
					else 
					{
						while($dis = mysqli_fetch_array($display))
						{
							$messto = $dis['messto'];
							$messfrom = $dis['messfrom'];
							$chatid = $dis['chatid'];
							$repairmanid = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$messfrom' OR repairmanid = '$messto'");
		                  	while ($rep = mysqli_fetch_array($repairmanid))
		                    {
		                      $rfname = $rep['fname'];
		                      $rlname = $rep['lname'];
		                      $rprofilepix = $rep['profilepix'];
		                    }
							if($dis['useen'] == 0)
							{ ?>
								<b><a href="messages.php?chatid=<?php echo$chatid?>&from=<?php if($messfrom == $userid){ echo$messto; } else { echo$messfrom; } ?>" style="text-decoration:none"><div class="alert alert-success" style="margin-left:5px;margin-bottom:4px;margin-right:5px;height:56px;width:200px;margin-top:5px;width:290px">
					            <img style="margin-top:-5px;margin-left:15px;height:40px;width:40px;border-radius:100px" src="../profilepix/<?php echo$rprofilepix ?>"><p style="display:inline;margin-left:5px;font-size:1.1em"> <?php echo$rfname ?> <?php echo$rlname ?></p></div></a></b>		                   
					<?php   }
							else
							{ ?>
								<a href="messages.php?chatid=<?php echo$chatid?>&from=<?php if($messfrom == $userid){ echo$messto; } else { echo$messfrom; } ?>" style="text-decoration:none"><div class="alert alert-secondary" style="margin-left:5px;margin-bottom:4px;margin-right:5px;height:56px;width:200px;margin-top:5px;width:290px"><img style="margin-top:-5px;margin-left:15px;height:40px;width:40px;border-radius:100px" src="../profilepix/<?php echo$rprofilepix ?>"><p style="display:inline;margin-left:5px;font-size:1.1em"> <?php echo$rfname ?> <?php echo$rlname ?></p></div></a>		                
					  <?php }
					    }
					}
?>