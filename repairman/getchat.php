<?php 

include('../includes/config.php');

$repairmanid = $_POST['repairmanid'];

$display = mysqli_query($database, "SELECT * FROM message WHERE messto = '$repairmanid' OR messfrom = '$repairmanid' GROUP BY chatid ORDER BY id ASC");

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
							if($dis['messfrom'] == $repairmanid)
							{
								$messto = $dis['messto'];
								$messto = mysqli_query($database, "SELECT * FROM users WHERE userid = '$messto'");
					            while ($use = mysqli_fetch_array($messto))
					            {
					                $ccfname = $use['fname'];
					                $cclname = $use['lname'];
					                $ccprofilepix = $use['profilepix'];
					            }
				            }
				            else 
				            {
				            	$messfrom = $dis['messfrom'];
								$messfrom = mysqli_query($database, "SELECT * FROM users WHERE userid = '$messfrom'");
					            while ($use = mysqli_fetch_array($messfrom))
					            {
					                $ccfname = $use['fname'];
					                $cclname = $use['lname'];
					                $ccprofilepix = $use['profilepix'];
					            }
				            }
							if($dis['rseen'] == 0)
							{ ?>
								<b><a href="messages.php?chatid=<?php echo$dis['chatid'] ?>messfrom=<?php if($dis['messfrom'] == $repairmanid){ echo $dis['messto']; } else { echo $dis['messfrom']; } ?>" style="text-decoration:none"><div class="alert alert-success" style="margin-left:5px;margin-bottom:4px;margin-right:5px;height:56px;width:200px;margin-top:5px;width:290px">
				                  <img style="margin-top:-5px;margin-left:15px;height:40px;width:40px;border-radius:100px" src="../profilepix/<?php echo$ccprofilepix ?>"><p style="display:inline;margin-left:5px;font-size:1.1em"> <?php echo$ccfname ?> <?php echo$cclname ?></p>
				                </div></a></b>
					<?php   }
							else
							{ ?>
								<a href="messages.php?chatid=<?php echo$dis['chatid'] ?>&messfrom=<?php if($dis['messfrom'] == $repairmanid){ echo $dis['messto']; } else { echo $dis['messfrom']; } ?>" style="text-decoration:none"><div class="alert alert-secondary" style="margin-left:5px;margin-bottom:4px;margin-right:5px;height:56px;width:200px;margin-top:5px;width:290px">
				                  <img style="margin-top:-5px;margin-left:15px;height:40px;width:40px;border-radius:100px" src="../profilepix/<?php echo$ccprofilepix ?>"><p style="display:inline;margin-left:5px;font-size:1.1em"> <?php echo$ccfname ?> <?php echo$cclname ?></p>
				                </div></a>			                
					  <?php }
						}
					}
				?>