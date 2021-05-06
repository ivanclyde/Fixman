<?php include 'includes/header.php'; ?>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php" class="font-weight-bold">Home</a></li>
				<li class="breadcrumb-item" aria-current="page">Contact Us</li>
			</ol>
	</div>
	<div class="contact py-5" id="contact">
		<div class="container pb-xl-5 pb-lg-3">
			<div class="row">
				<div class="col-lg-6">
					<img src="images/b2.png" alt="image" class="img-fluid" />
				</div>
				<div class="col-lg-6 mt-lg-0 mt-5">
					<div class="contact-top1">
						<?php 
							if (isset($_POST['submit'])) 
							{
								$firstname = mysqli_real_escape_string($database,$_POST['firstname']);
								$lastname = mysqli_real_escape_string($database,$_POST['lastname']);
								$mobile = mysqli_real_escape_string($database,$_POST['mobile']);
								$email = mysqli_real_escape_string($database,$_POST['email']);
								$message = mysqli_real_escape_string($database,$_POST['message']);

								$firstname = ucfirst($firstname);
								$lastname = ucfirst($lastname);

								mysqli_query($database, "INSERT INTO contactus (firstname, lastname, mobile, email, message) VALUES ('$firstname','$lastname','$mobile','$email','$message')");

								echo '<script>alert("Message Sent"); window.location.href="contact.php"</script>';
							}
						?>
						<form action="#" method="post" class="contact-wthree-do">
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>First name</label>
										<input class="form-control" type="text" placeholder="First name" name="firstname" required="">
									</div>
									<div class="col-md-6 mt-md-0 mt-4">
										<label>Last name</label>
										<input class="form-control" type="text" placeholder="Last name" name="lastname" required="">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Mobile</label>
										<input class="form-control" type="text" placeholder="xxxx xxxx xx" name="mobile" required="">
									</div>
									<div class="col-md-6 mt-md-0 mt-4">
										<label>Email</label>
										<input class="form-control" type="email" placeholder="example@mail.com" name="email" required="">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Your message</label>
										<textarea placeholder="Add your Description here" name="message" class="form-control"></textarea>
									</div>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-md-12">
									<button type="submit" class="btn btn-cont-w3 btn-block mt-4" name="submit">Send</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php include 'includes/indexfooter.php'; ?>