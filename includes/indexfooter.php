	<footer class="bg-li py-5">
		<div class="container py-xl-5 py-lg-3">
			<div class="subscribe mx-auto">
				<div class="icon-effect-w3">
					<span class="fa fa-envelope"></span>
				</div>
				<h2 class="tittle text-center font-weight-bold">Stay Updated!</h2>
				<br>
				<?php 
					if(isset($_POST['submit']))
					{
						$email = mysqli_real_escape_string($database, $_POST['email']);

						mysqli_query($database, "INSERT INTO subscribe (email) VALUES ('$email')");
						echo '<script>alert("Thank you for subscribing to FIX-MAN"); window.location.href="index.php"</script>';
					}
				?>
				<form action="#" method="post" class="subscribe-wthree pt-2">
					<div class="d-flex subscribe-wthree-field">
						<input class="form-control" type="email" placeholder="Enter your email..." name="email" required="">
						<button class="btn form-control w-50" type="submit" name="submit">Subscribe</button>
					</div>
				</form>
			</div>
		</div>
	</footer>
<footer class="container-fluid" style="background-color:#F8F9FA;margin-top:absolute;padding:15px;color:white">
	<table style="color:black;">
		<tr>
		   <th></th>
		   <th width="200px"><center>About Us</center></th>
		   <th width="200px"><center>Follow Us</center></th>
		   <th width="200px"><center>Contact Us</center></th>
		</tr>
		<tr>
		   <td rowspan="5" width="200px"><center><img src="images/mana.png" width="200px" height="200px"></center></td>
		   <td rowspan="4" style="text-align:justify;padding-right:50px;padding-left:50px">FIXMAN. Is a Web-ased Application platform for booking a repairman.The main goal of the system is to provide the right and the perfect repairmanto do the work in the comfort of their homes or at any specific location..</td>
		   <td style="padding-left:50px"><a href="https://www.facebook.com/rafflesia.fixman/" target="_blank"><i class="bi bi-facebook"></i> FIX-MAN Official <i class="bi bi-check-circle-fill"></i></a></td>
		   <td style="padding-left:50px"><i class="bi bi-telephone-inbound-fill"></i> (0912)-345-6789</td>
		</tr>
		<tr>
		   <td style="padding-left:50px"><a href="https://www.instagram.com/rafflesiafixman/" target="_blank"><i class="bi bi-instagram"></i> FIX-MAN Official <i class="bi bi-check-circle-fill"></i></a></td>
		   <td style="padding-left:50px">Rafflesiathefixman@yahoo.com</td>
		</tr>
		<tr>
		   <td style="padding-left:50px"><a href="https://twitter.com/RFixman" target="_blank"><i class="bi bi-twitter"> @fix-man official <i class="bi bi-check-circle-fill"></i></a></td>
		   <td style="padding-left:50px">Rafflesiathefixman@gmail.com</td>
		</tr>
		<tr>
			<td></td>
			<td style="padding-left:50px">Rafflesiathefixman@outlook.com</td>
		</tr>
	</table>
</footer>
	<div class="copy-bottom bg-li py-4 border-top">
		<div class="container-fluid">
			<div class="d-md-flex px-md-3 position-relative text-center">
				<div class="copy_right mx-md-auto mb-md-0 mb-3">
					<p class="text-bl let">Copyright © 2021 FIX-MAN. All rights reserved. ®<a href="includes/terms.php" target="_blank"> Terms of Use</a> | <a href="includes/privacypolicy.php" target="_blank"> Privacy Policy</a></p>
				</div>
				<a href="#home" class="move-top text-center">
					<span class="fa fa-level-up" aria-hidden="true"></span>
				</a>
			</div>
		</div>
	</div>
</body>
</html>