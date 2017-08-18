<?php
include "keymanager.php";

function getDates() {
  $now = new DateTime();
  return $now->format('Y-m-d h');
}

function hasher5($mdp) {
  return hash('sha256',$mdp."de".getDates());
}

if (isset($_POST['password'])) {
	$pass = htmlspecialchars($_POST['password']);
	if (adminKey()==$pass) {
		header("Location: cpanel.php?key=".hasher5(getKey("adminKey")));
	} else {
		$error = 'Invalid Password';
	}
}
?>
<html>
	<head>
		<title>Admin Panel</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/base.css">
	</head>
	<body>
		<form method="POST" action="" class="form-horizontal">
  		<fieldset>
  			<div align="center">
   			 	<h2>Connect</legend>
   			 </div>
   			<div class="form-group">
      			<label for="adminKey" class="col-lg-2 control-label">PassWord</label>
      			<div class="col-lg-10">
		            <?php 
		       		    if (isset($error)) {
		                	echo '<div class="form-group has-error">';
		                	echo '<label class="control-label" for="password">'.$error.'</label>';
		                	echo '<input type="text" class="form-control" id="password" name="password" placeholder="PassWord">';
		                	echo '</div>';
		                } else {
		                	echo '<input type="text" class="form-control" id="password" name="password" placeholder="PassWord">';
		                }
		            ?>
      			</div>
    		</div>
   			<div class="form-group">
      			<div class="col-lg-10 col-lg-offset-2">
        			<button type="submit" class="btn btn-primary">Login</button>
      			</div>
    		</div>
  		</fieldset>
	</form>
	</body>
</html>