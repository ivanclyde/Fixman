<?php 

include('../includes/config.php');

$userid = $_POST['userid'];

$badge = mysqli_query($database, "SELECT * FROM notification WHERE notifto = '$userid' AND status=0");
$count = mysqli_num_rows($badge);
$color = mysqli_query($database, "SELECT * FROM notification WHERE notifto = '$userid'ORDER BY created DESC LIMIT 5");

            if (mysqli_num_rows($color) == 0)
            {
              echo '&nbsp';
              echo '<center><p><b>No New Notification</b></p></center>';
            }
            else
            {
              while ($not = mysqli_fetch_array($color)) 
              { 
                if($not['status'] == 0)
                { ?><form method="post" action="#.php">
                    <table style="margin-bottom:5px;margin-top:5px;margin-left:5px;margin-right:5px;cursor:pointer;">
                      <tr class="alert alert-success">
                        <td align="left" style="padding-right:5px;font-size:0.8em;width:150px;"><button type="submit" name="deletenotif" style="text-decoration:none;border:none;background-color:#D4EDDA;outline:none;color:blue;cursor:pointer;" value="<?php echo$not['no'] ?>"><i class="bi bi-trash" data-toggle="tooltip" title="Delete"></i></button><button type="submit" name="markasread" style="text-decoration:none;border:none;background-color:#f1f1f1;outline:none;color:blue;cursor:pointer;background-color:#D4EDDA" value="<?php echo$not['no'] ?>"><i class="bi bi-envelope-open" data-toggle="tooltip" title="Mark as Read"></i></button><button type="submit" name="markasunread" style="text-decoration:none;border:none;background-color:#D4EDDA;outline:none;color:blue;cursor:pointer" value="<?php echo$not['no'] ?>"><i class="bi bi-envelope" data-toggle="tooltip" title="Mark as Unread"></i></button></td>
                        <td align="right" style="width:600px;padding-right:5px;font-size:0.8em;"  onclick="window.location='<?php echo $not['link'] ?>';"><?php echo $newcreated =date('F d, Y h:i:sa',strtotime($not['created']))?></td>
                      </tr>
                      <tr class="alert alert-success" style="width:550px;font-size:1em;">
                        <td colspan="5" style="padding-right:5px;padding-left:5px;padding-bottom:5px;font-size:0.9em"  onclick="window.location='<?php echo $not['link'] ?>';"><?php echo $not['content']?></td>
                      </tr>
                    </table>
                    </form>
            <?php }
                else
                { ?><form method="post" action="#.php">
                    <table style="margin-bottom:5px;margin-top:5px;margin-left:5px;margin-right:5px;cursor:pointer;">
                      <tr class="alert alert-light">
                        <td align="left" style="padding-right:5px;font-size:0.8em;background-color:#F1F1F1;width:150px"><button type="submit" name="deletenotif" style="text-decoration:none;border:none;background-color:#f1f1f1;outline:none;color:blue;cursor:pointer" value="<?php echo$not['no'] ?>"><i class="bi bi-trash" data-toggle="tooltip" title="Delete"></i></button><button type="submit" name="markasread" style="text-decoration:none;border:none;background-color:#f1f1f1;outline:none;color:blue;cursor:pointer" value="<?php echo$not['no'] ?>"><i class="bi bi-envelope-open" data-toggle="tooltip" title="Mark as Read"></i></button><button type="submit" name="markasunread" style="text-decoration:none;border:none;background-color:#f1f1f1;outline:none;color:blue;cursor:pointer" value="<?php echo$not['no'] ?>"><i class="bi bi-envelope" data-toggle="tooltip" title="Mark as Unread"></i></button></td>
                        <td align="right" style="width:500px;padding-right:5px;font-size:0.8em;background-color:#F1F1F1"  onclick="window.location='<?php echo $not['link'] ?>';"><?php echo $newcreated =date('F d, Y h:i:sa',strtotime($not['created']))?></td>
                      </tr>
                      <tr class="alert alert-light" style="width:500px;font-size:1em;background-color:#F1F1F1">
                        <td colspan="5" style="padding-right:5px;padding-left:5px;padding-bottom:5px;font-size:0.9em"  onclick="window.location='<?php echo $not['link'] ?>';"><?php echo $not['content']?></td>
                      </tr>
                    </table>
                    </form>
            <?php }
                }
            }
?>
<form method="post" action="#.php">
  <?php 
    if (mysqli_num_rows($color) > 0)
      { ?>
        <hr style="margin-top:0px">
        <div class="text-center" style="margin-top:-10px">
          <button type="submit" name="clearnotif" style="text-decoration:none;border:none;background-color:white;outline:none;color:blue;cursor:pointer" onclick="return confirm('Clear Notifications?')">Clear Notification</button>
        </div>
<?php }
  ?>
</form>