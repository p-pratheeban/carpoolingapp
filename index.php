<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
	<title>Carpooling Rideshare Application</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/carpooling.css">

</head>
<body>
<div class="containner">
	<!-- header -->
	<div class="row home">
		<div class="col-lg-6 center">	
		<h1><strong>Carpooling Rideshare</strong></h1>		
		</div>
		<div class="col-lg-6">
			<form method="POST" action="php/login.php">
				<div class="col-lg-10">
					<?php 
					if(isset($_GET["error"])){
					?>
					<label class="error"><?= $_GET["error"] ?></label>
					<?php
					}
					?>
				</div>
				<div class="form-group col-lg-5">
					<label for="user" class="control-label">Username</label><br/>
			        <input type="text" class="form-control" id="user" name="user" placeholder="Username" required>    
				</div>

				<div class="form-group col-lg-5">
					<label for="pass" class="control-label">Password</label><br/>
					<input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required>	
				</div>
				<div class="form-group col-lg-2">
					<button type="submit" class="btn btn-primary loginbtn">Login</button>
				</div>
			</form>
		</div>
	</div>
	<!-- Sign Up -->
	<div class="row homecontent">
		<div class="col-lg-6 center">
			<img src="images/carpool.jpg" alt="carpool">
		</div>
		<div class="col-lg-6">
		<form method="POST" action="php/signup.php">
			<h2><strong>Sign Up</strong></h2>
			<div class="form-group col-lg-6">
			
	  			<label for="email">Username</label>
	   			<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
	  		</div>
	  		<div class="form-group col-lg-6 clear">
			    <label for="newpassword">Password</label>
			    <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New password" required>
			</div>
	  		<div class="form-group col-lg-6 clear">
	  			<label for="email">Email address</label>
	   			<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
	  		</div>
	  		<div class="form-group col-lg-6 clear">		
	  		<button type="submit" class="btn btn-success">Sign Up</button>
			</form>
			</div>
			
		</div>
	</div>
	
</div>
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/carpooling.js"></script>

</body>
</html>