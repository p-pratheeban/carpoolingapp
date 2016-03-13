<?php
	session_start();
	if(!isset($_SESSION['username'])){
			header("Location:./../index.php");
	}
	$user = $_SESSION["username"];

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
	<title>Carpooling Rideshare Application</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../css/carpooling.css">

</head>
<body>
<div> 
	<div class="row">
		<nav class="navbar navbar-default">
	  		<div class="container-fluid">
	    	<div class="navbar-header">
		    	<a class="navbar-brand" href="#">Carpooling Rideshare</a>
		    </div>
		    <form class="navbar-form navbar-left" role="search">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search Trips" id="keyword" size="60">
		        </div>
		        <button class="btn btn-default" id="searchbtn">search</button>
		      </form>
		      <ul class="nav navbar-nav navbar-right">
		      	<li><a href="#"><img src="../images/user24.jpg" alt="user" height="24" width="24"><strong><?= $user ?></strong></a></li>
		        <li><a href="#" id="getHome">Home</a></li>
		        <li><a href="#" id="getposts">Posts</a></li>
		        <li><a href="#" id="getfavorites">Favorites</a></li>
		        <li><a href="logout.php">Logout</a></li>
		      </ul>
		    </div>
		</nav>
	</div>
	<div class="row content">
		<div class="col-lg-2 userimg">
			<img src="../images/user150.jpg" alt="user" height="150" width="150">
			<figcaption><strong><?= $user ?></strong></figcaption>
		</div>
		<div class="col-lg-8">
			<div class="row" id="newpost">
				<div class="col-lg-2"><strong class="user"><?= $user ?></strong></div>
				<form role="form">
					<div class="form-group col-lg-10">
						 <textarea id="txtBoxPostTrip" placeholder="What's your trip plan?" cols="100" rows="4"></textarea>
					</div>
					<div class="col-lg-10 pull-right">
					<button type="submit" class="btn btn-primary"  id="btnPostTrip">Post</button>
					</div>
				</form>
			</div>
			<div class="row" id="postText">
			
			</div>
		</div>
		<div class="col-lg-2">
			
		</div>
	</div>

</div>
<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/carpooling.js"></script>

</body>
</html>