<?php 
session_start();

  if (!isset($_SESSION['repairmanid'])) 
  {
    header('Location: index.php');
  }

  include('../includes/config.php');

  $repairmanid = $_SESSION['repairmanid'];

  $repairman = mysqli_query($database, "SELECT * FROM repairman WHERE repairmanid= '$repairmanid'");
  while ($repair = mysqli_fetch_array($repairman)) 
  {
  	$fname = $repair['fname'];
  	$lname = $repair['lname'];
  	$profilepix = $repair['profilepix'];
  	$fee = $repair['fee'];
    $category = $repair['category'];
  }

  $moodofpayment= mysqli_query($database, "SELECT * FROM moodofpayment WHERE repairmanid = '$repairmanid'");
  while ($mod = mysqli_fetch_array($moodofpayment)) 
  {
    $bank = $mod['bank'];
    $bankno = $mod['bankno'];
    $name = $mod['name'];
    $paymentapp = $mod['paymentapp'];
    $paymentappname = $mod['paymentappname'];
    $paymentappnumber = $mod['paymentappnumber'];
    $paymentappqrcode = $mod['paymentappqrcode'];
  }
  $mood= mysqli_query($database, "SELECT * FROM moodofpayment WHERE repairmanid = '$repairmanid'");
  $checkmood = mysqli_num_rows($mood);

  if(isset($_POST['setpayment']))
  {
    $target = "../qrcodes/".basename($_FILES['paymentappqrcode']['name']);

    $repairmanid = mysqli_real_escape_string($database, $_SESSION['repairmanid']);
    $fee = mysqli_real_escape_string($database, $_POST['fee']);
    $bank = mysqli_real_escape_string($database, $_POST['bank']);
    $bankno = mysqli_real_escape_string($database, $_POST['bankno']);
    $name = mysqli_real_escape_string($database, $_POST['name']);
    $paymentapp = mysqli_real_escape_string($database, $_POST['paymentapp']);
    $paymentappname = mysqli_real_escape_string($database, $_POST['paymentappname']);
    $paymentappnumber = mysqli_real_escape_string($database, $_POST['paymentappnumber']);
    $paymentappqrcode = $_FILES['paymentappqrcode']['name'];

    move_uploaded_file($_FILES['paymentappqrcode']['tmp_name'], $target);

    mysqli_query($database, "INSERT INTO moodofpayment(repairmanid, bank, bankno, name, paymentapp, paymentappname, paymentappnumber, paymentappqrcode) values('$repairmanid','$bank','$bankno','$name','$paymentapp','$paymentappname','$paymentappnumber','$paymentappqrcode')");
    mysqli_query($database, "UPDATE repairman SET fee='$fee' , paymentopt='1', transaction = 'Available' WHERE repairmanid='$repairmanid'");
    echo "<script>alert('Payment Option has been set'); 
       window.location.href='paymentoptions.php'</script>";
  }

  if(isset($_POST['updatepayment']))
  {
    $repairmanid = mysqli_real_escape_string($database, $_SESSION['repairmanid']);
    $fee = mysqli_real_escape_string($database, $_POST['fee']);
    $bank = mysqli_real_escape_string($database, $_POST['bank']);
    $bankno = mysqli_real_escape_string($database, $_POST['bankno']);
    $name = mysqli_real_escape_string($database, $_POST['name']);
    $paymentapp = mysqli_real_escape_string($database, $_POST['paymentapp']);
    $paymentappname = mysqli_real_escape_string($database, $_POST['paymentappname']);
    $paymentappnumber = mysqli_real_escape_string($database, $_POST['paymentappnumber']);

    mysqli_query($database, "UPDATE moodofpayment SET bank='$bank', bankno='$bankno',name='$name', paymentapp='$paymentapp', paymentappname='$paymentappname', paymentappnumber='$paymentappnumber' WHERE repairmanid='$repairmanid'");
    mysqli_query($database, "UPDATE repairman SET fee='$fee' WHERE repairmanid='$repairmanid'");
    echo "<script>alert('Payment Option has been updated'); window.location.href='paymentoptions.php'</script>";
  }

  if(isset($_FILES['profilepix']))
  {
   $profilepix = $_FILES['profilepix']['name'];
   $target = "../profilepix/".basename($_FILES['profilepix']['name']);
   move_uploaded_file($_FILES['profilepix']['tmp_name'], $target);

   mysqli_query($database, "UPDATE repairman SET profilepix='$profilepix' WHERE repairmanid='$repairmanid'");
   echo '<script>window.location.href="paymentoptions.php"</script>';
  }

  if(isset($_FILES['paymentappqrcode']))
  {
   $paymentappqrcode = $_FILES['paymentappqrcode']['name'];
   $target = "../qrcodes/".basename($_FILES['paymentappqrcode']['name']);
   move_uploaded_file($_FILES['paymentappqrcode']['tmp_name'], $target);

   mysqli_query($database, "UPDATE moodofpayment SET paymentappqrcode='$paymentappqrcode' WHERE repairmanid='$repairmanid'");
   echo "<script>alert('QR Code Changed Successfully'); 
       window.location.href='paymentoptions.php'</script>";
  }

  $rating = mysqli_query($database, "SELECT sum(rate) AS rate FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
  $rates =mysqli_query($database, "SELECT * FROM ratingsandfeedback WHERE repairmanid = '$repairmanid'");
  while($rat = mysqli_fetch_array($rating))
  {
    $number = mysqli_num_rows($rates);
    $rate = $rat['rate'];
    if($rate == 0)
    { 
      $totalrate = '0.0';
    }
    else
    {
      $totalrate = $rate / $number;
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  	<title>Payment Options</title>
    <meta charset="utf-8">
    <link rel="icon" href="../images/mana.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="fullcalendar/lib/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
     rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="repairman.css">
<style type="text/css">
.table>tbody>tr>td,
.table>tbody>tr>th {
    border-top: none;
    padding: 5px !important;
}
.payment {
	  width: 200px;
}
</style>
</head>
<body>
<form id="image" action="#.php" method="post" enctype="multipart/form-data">
    <input type="file" id="profile" name="profilepix" accept="image/gif, image/jpeg, image/png" style="visibility:hidden;display:none" />
</form>
<form id="qrimage" action="#.php" method="post" enctype="multipart/form-data">
    <input type="file" id="qrcode1" name="paymentappqrcode" accept="image/gif, image/jpeg, image/png" style="visibility:hidden;display:none" />
</form>

<?php include('repairmanheader.php')?>
<div class="container-fluid" style="margin-top:5px;">
	<div class="row">
    	<div style="background-color:#F1F1F1;height:800px;width:330px !important">
	       <center><div class="img_div">
	         <br>
	         <img src="../profilepix/<?php echo $profilepix ?>" style="width:200px;height:200px;border-radius:100px">
           <h3><?php echo $fname ?> <?php echo $lname ?></h3>
           <h6>( <?php echo$category; ?> )</h6>
           <h7><b>Rating :</b> <?php if($totalrate == 0) { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } else { echo$totalrate; echo ' '; echo "<span style='color:  #FFFF00;font-size:1.2em'>"; echo "&#x2605;"; } ?></h7>
	         <hr class="solid">
	         <label for="profile" class="btn btn-success"><i class="bi bi-person-circle"></i> Change Picture</label> 
	       </div></center><br>
         <div style="margin-left:80px">
	         <a href="repairmanprofile.php" style="margin-bottom:5px;text-decoration:none;color:black">Profile</a><br>
	         <a class="btn btn-warning" href="paymentoptions.php" style="width:210px;margin-bottom:5px"><strong>Payment Options</strong></a><br>
           <a href="certificates.php" style="margin-bottom:5px;text-decoration:none;color:black">Portfolio</a><br>
	         <a href="ratingsandfeedback.php" style="text-decoration:none;color:black">Ratings and Feedbacks</a>
         </div>
    	</div>
    	<div class="col-sm-9">
    		<div id="accordion" style="margin-left:-5px">
    			<div class="card" style="width:990px">
            <div class="card-header" id="headingOne" style="background-color:skyblue">
              <h5 class="mb-0">
                <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <h4><b>Payment Options</b></h4>
                  <?php if(empty(mysqli_num_rows($mood))){ }else{echo '<a class="float-right" href="#.php" data-toggle="modal" data-target="#editpayment" style="font-size:0.8em"><i class="bi bi-pencil-square"></i> Edit</a>';}?>
                </a>
              </h5>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <?php 
              if(mysqli_num_rows($mood) == 1)
              { ?>
                <table>
                  <tr>
                    <td><b>Fee</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td>₱ <?php echo number_format($fee, 2);?> /day</td>
                  </tr>
                  <tr>
                    <td colspan="5"><h4><b>Bank Account</b></h4></td>
                  </tr>
                  <tr>
                    <td><b>Bank</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $bank;?></td>
                  </tr>
                  <tr>
                    <td><b>Bank Number</b></td>
                    <td>&nbsp</td>
                    <td><?php echo $bankno;?></td>
                  </tr>
                  <tr>
                    <td><b>Name</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $name;?></td>
                  </tr>
                  <tr>
                    <td colspan="5"><h4><b>Payment App</b></h4></td>
                  </tr>
                  <tr>
                    <td><b>Payment App</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $paymentapp;?></td>
                  </tr>
                  <tr>
                    <td><b>Name</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $paymentappname;?></td>
                  </tr>
                  <tr>
                    <td><b>Account Number</b></td>
                    <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
                    <td><?php echo $paymentappnumber;?></td>
                  </tr>
                  <tr>
                    <td><b>QR Code</b></td>
                    <td></td>
                    <td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#qrcode">View QR</button></td>
                  </tr>
                </table>
              <?php }
              else
              { ?>
                <div class="alert alert-danger" role="alert">
                  <h4 align="center" class="alert-heading">No Payment Option Set</h4>
                  <h5 align="center" class="alert-heading">Set Payment Option Below</h5>
                  <h6 align="center">NOTE: You cannot accept bookings if you haven't set your payment options.</h6>
                </div>
                <form action="#.php" method="post" enctype="multipart/form-data">
    		        <input type="hidden" name="size" value="1000000">
    		        <table class="table">
    		          <tr>
    		            <td><b>Fee</b></td>
    		            <td><input type="text" class="form-control payment" name="fee" placeholder="Enter fee" required="required"></td>
              		  </tr>
    		          <tr>
    		            <td colspan="5"><h4><b>Bank Account</b></h4></td>
    		          </tr>
    		          <tr>
    		            <td><b>Bank</b></td>
    		            <td><select name="bank" class="form-control payment" required="required">
    		              <option value="">Choose Bank Account</option>
    		              <option value="BPI">BPI</option>
    		              <option value="BDO">BDO</option>
    		              <option value="Metrobank">Metrobank</option>
    		              <option value="Landbank">Landbank</option>
    		              <option value="PNB">PNB</option>
    		              <option value="Chinabank">Chinabank</option>
    		            </select></td>
    		          </tr>
    		          <tr>
    		            <td><b>Account Number</b></td>
    		            <td><input type="text" class="form-control payment" name="bankno" placeholder="Enter account number" required="required"></td>
    		          </tr>
    		          <tr>
    		            <td><b>Full Name</b></td>
    		            <td><input type="text" class="form-control payment" name="name" placeholder="Enter fullname" required="required"></td>
    		          </tr>
    		          <tr>
    		            <td colspan="5"><h4><b>Payment Apps</b></h4></td>
    		          </tr>
    		          <tr>
    		            <td><b>Payment App</b></td>
    		            <td><select name="paymentapp" class="form-control payment">
    		                  <option value="">Choose Payment App</option>
    		                  <option value="GCash">GCash</option>
    		                  <option value="Coins.Ph">Coins.Ph</option>
    		                  <option value="PayMaya">PayMaya</option>
    		                </select></td>
    		          </tr>
    		          <tr>
    		            <td><b>Full Name</b></td>
    		            <td><input type="text" class="form-control payment" name="paymentappname" placeholder="Enter fullname" required="required"></td>
    		          </tr>
    		          <tr>
    		            <td><b>Account Number</b></td>
    		            <td><input type="text" class="form-control payment" name="paymentappnumber" placeholder="Enter number" required="required"></td>
    		          </tr>
    		          <tr>
    		            <td><b>QR Code</b></td>
    		            <td><input class="form-control payment" type="file" name="paymentappqrcode" required="required"></td>
    		          </tr>
    		          <tr>
    		            <td></td>
    		            <td><input class="btn btn-success" type="submit" name="setpayment" value="Set Payment Options"></td>
    		          </tr>
    		        </table>
    		        </form>
              <?php }
              ?>
              </div>
            </div>
          </div>
    		</div>
    	</div>
    </div>
</div>
<!---Modal for Payment Options--->
<form action="#.php" method="post" enctype="multipart/form-data">
<div class="modal fade" id="editpayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h4 class="modal-title" id="exampleModalLabel">&emsp;&emsp;&emsp;&emsp;&nbsp&nbsp&nbsp<b>Edit Payment Option</b></h4>
      </center>
      </div>
      <div class="modal-body">
        <table class="table">
            <tr>
              <td><b>Fee</b></td>
              <td><input class="form-control" type="text" name="fee" placeholder="₱000.00" required="required" value=<?php echo $fee?>></td>
            </tr>
            <tr>
              <td colspan="5"><h4><b>Bank Account</b></h4></td>
            </tr>
            <tr>
              <td><b>Bank</b></td>
              <td><select name="bank" class="form-control">
                  <option value="">Choose Bank Account</option>
                  <option value="BPI" <?= $bank == 'BPI' ? 'selected' : '' ?>>BPI</option>
                  <option value="BDO" <?= $bank == 'BDO' ? 'selected' : '' ?>>BDO</option>
                  <option value="Metrobank" <?= $bank == 'Metrobank' ? 'selected' : ''?>>Metrobank</option>
                  <option value="Landbank" <?= $bank == 'Landbank' ? 'selected' : '' ?>>Landbank</option>
                  <option value="PNB" <?= $bank == 'PNB' ? 'selected' : '' ?>>PNB</option>
                  <option value="Chinabank" <?= $bank == 'Chinabank' ? 'selected' : ''?>>Chinabank</option>
              </select></td>
            </tr>
            <tr>
              <td><b>Bank Number</b></td>
              <td><input class="form-control" type="text" name="bankno" placeholder="Enter bank number" required="required" value=<?php echo$bankno;?>></td>
            </tr>
            <tr>
              <td><b>Name</b></td>
              <td><input class="form-control" type="text" name="name" placeholder="Enter fullname" required="required" value="<?php echo$name;?>"/></td>
            </tr>
            <tr>
              <td colspan="5"><h4><b>Payment App</b></h4></td>
            </tr>
            <tr>
              <td><b>Payment App</b></td>
              <td><select name="paymentapp" class="form-control">
                <option value="">Choose Payment App</option>
                <option value="GCash" <?= $paymentapp == 'GCash' ? 'selected' : '' ?>>GCash</option> 
                <option value="Coins.Ph" <?= $paymentapp == 'Coins.Ph' ? 'selected' : '' ?>>Coins.Ph</option>
                <option value="PayMaya" <?= $paymentapp == 'PayMaya' ? 'selected' : '' ?>>PayMaya</option>
              </select></td>
            </tr>
            <tr>
              <td><b>Name</b></td>
              <td><input class="form-control" type="text" name="paymentappname" placeholder="Enter fullname" required="required" value="<?php echo$paymentappname;?>"/></td>
            </tr>
            <tr>
              <td><b>Account Number</b></td>
              <td><input class="form-control" type="text" name="paymentappnumber" placeholder="Enter account number" required="required" value=<?php echo$paymentappnumber;?>></td>
            </tr>
          </table>
      <div class="modal-footer">
      	<button class="btn btn-primary" type="submit" name="updatepayment">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
</div>
</form>
<!--- Modal for QR Code --->
<div id="qrcode" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>QR Code</b></h3>
      </div>
      <div class="modal-body">
        <center>
          <img src="../qrcodes/<?php echo $paymentappqrcode?>" width='350px' height='350px' style="border-radius:10px;">
        </center>
      </div>
      <div class="modal-footer">
        <label for="qrcode1" class="btn btn-success">Change QRCode</label>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</body>
<script type="text/javascript">
     $('#profile').on('change', function() {
        $('#image').submit();
    })
    $('#qrcode1').on('change', function() {
        $('#qrimage').submit();
    }) 
</script>
</html>