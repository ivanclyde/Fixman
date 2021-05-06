<?php 

include('../includes/config.php');

$userid = $_POST['userid'];

$messdisplay = mysqli_query($database, "SELECT * FROM message WHERE messto = '$userid' OR messfrom = '$userid' GROUP BY chatid ORDER BY id DESC");
              if (mysqli_num_rows($messdisplay) == 0)
              {
                echo '<center><div class="alert alert-danger" role="alert" style="width:auto; border-radius:5px;margin-bottom:3px;margin-right:5px;margin-left:5px">';
                echo 'No Messages <i class="bi bi-emoji-frown"></i>';
                echo '</div></center>';
              }
              else
              {
                while ($mess = mysqli_fetch_array($messdisplay)) 
                {
                  $chatid = $mess['chatid'];
                  $messfrom = $mess['messfrom'];
                  $messto = $mess['messto'];
                  $messfrom = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid = '$messfrom' OR repairmanid = '$messto'");
                  while ($rep = mysqli_fetch_array($messfrom))
                    {
                      $rfname = $rep['fname'];
                      $rlname = $rep['lname'];
                      $rprofilepix = $rep['profilepix'];
                    }
                  if($mess['useen'] == 0)
                  { ?>
                    <div class="alert alert-success" style="margin-left:5px;margin-bottom:4px;margin-right:5px;cursor:pointer;height:56px;width:220px" onclick="window.location='messages.php?chatid=<?php echo$chatid ?>&from=<?php if($mess['messfrom'] == $userid) { echo $mess['messto']; } else { echo $mess['messfrom']; } ?>';"><b>
                      <img style="margin-top:-5px;margin-left:-15px;height:40px;width:40px;border-radius:100px" src="../profilepix/<?php echo$rprofilepix ?>"><p style="display:inline;margin-left:5px;font-size:1em"> <?php echo$rfname ?> <?php echo$rlname ?></p>
                    </b></div>
            <?php }
                  else
                  { ?>

                    <div class="alert alert-secondary" style="margin-left:5px;margin-bottom:4px;margin-right:5px;cursor:pointer;height:56px;width:220px" onclick="window.location='messages.php?chatid=<?php echo$chatid ?>&from=<?php if($mess['messfrom'] == $userid) { echo $mess['messto']; } else { echo $mess['messfrom']; } ?>';">
                      <img style="margin-top:-5px;margin-left:-15px;height:40px;width:40px;border-radius:100px" src="../profilepix/<?php echo$rprofilepix ?>"><p style="display:inline;margin-left:5px;font-size:1em"> <?php echo$rfname ?> <?php echo$rlname ?></p>
                    </div>
            <?php }
                }
              }
            ?>
            <hr style="margin-top:0px">
            <p align="center" style="margin-top:-10px;margin-bottom:0px"><a href="message.php" style="text-decoration:none">See All Messages</a></p>