<?php 
              
    include('../includes/config.php');

    $repairmanid = $_POST['repairmanid'];

    $messdisplay = mysqli_query($database, "SELECT * FROM message WHERE messto = '$repairmanid' OR messfrom = '$repairmanid' GROUP BY chatid ORDER BY id ASC");
              if (mysqli_num_rows($messdisplay) == 0)
              {
                echo '&nbsp';
                echo '<center><p><b>No Messages</b></p></center>';
              }
              else
              {
                while ($mess = mysqli_fetch_array($messdisplay)) 
                {
                  $messfrom = $mess['messfrom'];
                  $messfrom = mysqli_query($database, "SELECT * FROM users WHERE userid = '$messfrom'");
                  while ($use = mysqli_fetch_array($messfrom))
                    {
                      $cfname = $use['fname'];
                      $clname = $use['lname'];
                      $cprofilepix = $use['profilepix'];
                    }
                  if($mess['rseen'] == 0)
                  { ?>
                    <div class="alert alert-success" style="margin-left:5px;margin-bottom:4px;margin-right:5px;cursor:pointer;height:56px;width:220px" onclick="window.location='messages.php?chatid=<?php echo$mess['chatid'] ?>&messfrom=<?php echo$mess['messfrom'] ?>';">
                      <img style="margin-top:-5px;margin-left:-15px;height:40px;width:40px;border-radius:100px" src="../profilepix/<?php echo$cprofilepix ?>"><p style="display:inline;margin-left:5px;font-size:1em"> <?php echo$cfname ?> <?php echo$clname ?></p>
                    </div>
            <?php }
                  else
                  { ?>

                    <div class="alert alert-secondary" style="margin-left:5px;margin-bottom:4px;margin-right:5px;cursor:pointer;height:56px;width:220px" onclick="window.location='messages.php?chatid=<?php echo$mess['chatid'] ?>&messfrom=<?php echo$mess['messfrom'] ?>';">
                      <img style="margin-top:-5px;margin-left:-15px;height:40px;width:40px;border-radius:100px" src="../profilepix/<?php echo$cprofilepix ?>"><p style="display:inline;margin-left:5px;font-size:1em"> <?php echo$cfname ?> <?php echo$clname ?></p>
                    </div>
            <?php }
                }
              }
            ?>
            <hr style="margin-top:0px">
            <p align="center" style="margin-top:-10px;margin-bottom:0px"><a href="message.php" style="text-decoration:none">See All Messages</a></p>