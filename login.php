<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	
<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");
?>

<style>
	body {
		width: 100%;
		height: calc(100%);
		position: fixed;
		top: 0;
		left: 0;
		background-color: white;
		overflow: hidden;
	}

	main#main {
		width: 100%;
		height: calc(100%);
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.card {
		background-color: #dbebfc;
		opacity: 0;
		transform: translateY(-20px);
		animation: fadeInUp 0.5s forwards;
	}

	@keyframes fadeInUp {
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	.btn-primary {
		transition: background-color 0.3s, transform 0.3s;
	}

	.btn-primary:hover {
		background-color: #0056b3;
		transform: scale(1.05);
	}

	.form-control {
		transition: border-color 0.3s;
	}

	.form-control:focus {
		border-color: #007bff;
		box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
	}
</style>

<body>
  <main id="main">
  	<div class="align-self-center w-100">
		<center><img src="logo.jpg"><br><h2 style="color:#0a67b7"><b>Attendance Management System</b></h2></center>
		<h4 class="text-white text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
  		<center>
  			<div style="bgcolor:white">
  				<div class="card col-md-4">
  					<div class="card-body">
  						<form id="login-form">
  							<div class="form-group">
  								<label for="username" class="control-label">Username</label>
  								<input type="text" id="username" name="username" class="form-control">
  							</div>
  							<div class="form-group">
  								<label for="password" class="control-label">Password</label>
  								<input type="password" id="password" name="password" class="form-control">
  							</div>
  							<center><button type="button" class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
  						</form>
  					</div>
  				</div>
  			</div>
		</center>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(document).ready(function() {
		$('.card').css('opacity', 1); // Ensure the card is visible after the animation
		$('#login-form').submit(function(e){
			e.preventDefault();
			$('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
			if($(this).find('.alert-danger').length > 0)
				$(this).find('.alert-danger').remove();
			$.ajax({
				url: 'ajax.php?action=login',
				method: 'POST',
				data : $(this).serialize(),
				error: err => {
					console.log(err);
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				},
				success: function(resp) {
					if(resp == 1) {
						location.href = 'index.php?page=home';
					} else {
						$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
						$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
					}
				}
			});
		});
	});
</script>
</html>