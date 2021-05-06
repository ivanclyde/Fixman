<?php 
  /***Notification***/
  
  if (isset($_POST['deletenotif'])) 
  {
    $no = mysqli_real_escape_string($database, $_POST['deletenotif']);
      mysqli_query($database, "DELETE FROM notification WHERE no = '$no'");
      header("Refresh:0");
  }
  if (isset($_POST['markasread'])) 
  {
    $no = mysqli_real_escape_string($database, $_POST['markasread']);
      mysqli_query($database, "UPDATE notification SET status = '1' WHERE no = '$no'");
      header("Refresh:0");
  }
  if (isset($_POST['markasunread'])) 
  {
    $no = mysqli_real_escape_string($database, $_POST['markasunread']);
      mysqli_query($database, "UPDATE notification SET status = '0' WHERE no = '$no'");
      header("Refresh:0");
  }
  if (isset($_POST['clearnotif'])) 
  {
      mysqli_query($database, "DELETE FROM notification WHERE notifto = '$_SESSION[userid]'");
      header("Refresh:0");
  }
?>
<nav class="bg-light" style="height:50px;">
  <div class="row">
    <div style="width:895px">
      <a class="navbar-brand" href="customerprofile.php" style="color:black !important;margin-left:25px"><img src="../profilepix/<?php echo $profilepix ?>" style="width:40px;height:40px;border-radius:100px"> <?php echo $fname?></a>
    </div>
    <div style="width:100px;">
      <a class="nav-link" href="customerhomepage.php" style="color:black !important;padding-top:13px;margin-left:-20px"><span class="bi bi-house"></span> <b>Home&emsp;</b></a>
    </div>
    <div style="width:150px;">
      <a class="nav-link" href="#" id="notification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black !important;padding-top:13px;margin-left:-25px"><i class="bi bi-bell"></i>
          <b>Notification</b>
        <div id="disbadge" style="display:inline">
          <!---Display Notifications badge Here --->
        </div></a>
        <div id="disnotif" class="dropdown-menu dropdown-menu-right" aria-labelledby="notification" style="width:400px">
          <!---- Display Notifications Here ----->
        </div>
    </div>
    <div style="width:140px;">
      <a class="nav-link" href="#" id="messages" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black !important;padding-top:13px;margin-left:-25px"><i class="bi bi-chat-dots"></i></i>
            <b>Messages </b>
          <div id="dismessbadge" style="display:inline">
            <!---Display Notifications badge here --->
          </div>
          </a>
          <div id="messageheader" class="dropdown-menu" aria-labelledby="messages">
            <!---Display header messages here --->
          </div>
    </div>
    <div style="width:90px;">
      <a class="nav-link" href="#" id="profile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black !important;padding-top:13px;margin-left:-35px"><i class="bi bi-person"></i>
          <b>Profile</b>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile" style="margin-right:10px">
          <button class="dropdown-item" type="button" onclick="location.href='customerprofile.php';"/><i class="bi bi-person-circle"></i> My Profile</button>
          <button class="dropdown-item" type="button" onclick="location.href='customerviewbookings.php';"/><i class="bi bi-calendar-range"></i> My Bookings</button>
          <div class="dropdown-divider"></div>
          <button class="dropdown-item" type="button" onclick="location.href='../logout.php';"/><i class="bi bi-box-arrow-right"></i> Log Out</button>
        </div>
    </div>
  </div>
</nav>
<script type="text/javascript">
  $(function() { 
    setInterval(function() {
      var userid = '<?php echo $_SESSION['userid'];?>';
      $.ajax ({
        url:'getnotifications.php',
        data: 'userid=' + userid,
        type: "POST",
        success:function(res){
          $('#disnotif').html(res);
        }
      })
    }, 500);
  })

  $(function() { 
    setInterval(function() {
      var userid = '<?php echo $_SESSION['userid'];?>';
      $.ajax ({
        url:'getnotifbadge.php',
        data: 'userid=' + userid,
        type: "POST",
        success:function(res){
          $('#disbadge').html(res);
        }
      })
    }, 500);
  })

  $(function() { 
    setInterval(function() {
      var userid = '<?php echo $_SESSION['userid'];?>';
      $.ajax ({
        url:'getmessagebadge.php',
        data: 'userid=' + userid,
        type: "POST",
        success:function(res){
          $('#dismessbadge').html(res);
        }
      })
    }, 500);
  })

  $(function() { 
    setInterval(function() {
      var userid = '<?php echo $_SESSION['userid'];?>';
      $.ajax ({
        url:'getmessheader.php',
        data: 'userid=' + userid,
        type: "POST",
        success:function(res){
          $('#messageheader').html(res);
        }
      })
    }, 500);
  })
</script>