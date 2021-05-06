<?php 

session_start();

if(isset($_POST['submit']))
{
	include('includes/config.php');

	$username = mysqli_real_escape_string($database, $_POST['username']);
	$password = mysqli_real_escape_string($database, $_POST['password']);

	$sqlusers = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$sqlrepairman = "SELECT * FROM repairman WHERE username='$username' AND password='$password'";
	$resultusers = mysqli_query($database, $sqlusers);
	$resultrepairman = mysqli_query($database, $sqlrepairman);
	$resultCheckusers = mysqli_num_rows($resultusers);
	$resultCheckrepairman = mysqli_num_rows($resultrepairman);


	if ($resultCheckusers < 1 AND $resultCheckrepairman < 1)
	{
		echo "<script>alert('Account Not Found'); window.location.href='login.php';</script>";
		exit();
	}
	else
	{
		if ($row = mysqli_fetch_array($resultrepairman) OR $row = mysqli_fetch_array($resultusers))
		{
			if ($row['user_type'] == 'Customer') 
			{
				if ($row['status'] == 'Not yet Verified')
				{
					echo "<script>alert('Please Verify your account first!'); window.location.href='login.php';</script>";
					exit();
				}
				else
				{
					if ($password != $row['password']) 
					{
						echo "<script>alert('Incorrect Password'); window.location.href='index.php';</script>";
						exit();
					}
					elseif ($password == $row['password']) 
					{
						$_SESSION['userid'] = $row['userid'];
						$_SESSION['password'] = $row['password'];
						$_SESSION['fname'] = $row['fname'];
						$_SESSION['lname'] = $row['lname'];
						$_SESSION['gender'] = $row['gender'];
						$_SESSION['user_type'] = $row['user_type'];

						mysqli_query($database,"INSERT INTO activitylog(user_type,id,created) VALUES ('Customer','{$_SESSION['userid']}',CURRENT_TIMESTAMP)");
						echo "<script>alert('Welcome {$_SESSION['fname']}!'); window.location.href='user/customerhomepage.php';</script>";
						exit();
					}
				}
			}
			elseif ($row['user_type'] == 'Repairman')
			{
				if ($row['status'] == 'Pending')
				{
					echo "<script>alert('Application Pending for Approval, please check email for confirmation!'); window.location.href='login.php';</script>";
					exit();
				}
				else
				{
					if($row['status'] == 'Denied')
					{
						echo "<script>alert('Your application has been denied'); window.location.href='login.php';</script>";
						exit();
					}
					else
					{
						if ($password != $row['password']) 
						{
							echo "<script>alert('Incorrect Password'); window.location.href='login.php';</script>";
								exit();
						}
						else
						{
							$_SESSION['repairmanid'] = $row['repairmanid'];
							$_SESSION['password'] = $row['password'];
							$_SESSION['fname'] = $row['fname'];
							$_SESSION['lname'] = $row['lname'];
							$_SESSION['gender'] = $row['gender'];
							$_SESSION['user_type'] = $row['user_type'];
							mysqli_query($database,"INSERT INTO activitylog(user_type,id,created) VALUES ('Repairman','{$_SESSION['repairmanid']}',CURRENT_TIMESTAMP)");
							echo "<script>alert('Welcome {$_SESSION['fname']}!'); window.location.href='repairman/repairmanhomepage.php';</script>";
							exit();
						}
					}
				}
			}
			else
			{
				if ($password != $row['password']) 
				{
					echo "<script>alert('Incorrect Password.');
						window.location.href='login.php';</script>";
				}
				else
				{
					$_SESSION['userid'] = $row['userid'];
					$_SESSION['password'] = $row['password'];
					$_SESSION['fname'] = $row['fname'];
					$_SESSION['lname'] = $row['lname'];
					$_SESSION['gender'] = $row['gender'];
					$_SESSION['user_type'] = $row['user_type'];
					echo "<script>alert('Welcome Admin {$_SESSION['fname']}!'); window.location.href='admin/adminhomepage.php';</script>";
				}
			}
		}	
	}
}
?>