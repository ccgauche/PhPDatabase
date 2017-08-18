<?php
include "keymanager.php";

function getDates() {
  $now = new DateTime();
  return $now->format('Y-m-d h');
}

function hasher5($mdp) {
  return hash('sha256',$mdp."de".getDates());
}

if (htmlspecialchars($_GET['key'])==hasher5(getKey("adminKey"))) {

} else {
  header("Location: admin.php");
}

if (isset($_POST['adminKey'])) {
	$Pa3 = htmlspecialchars($_POST['adminKey']);
	if (strlen($Pa3)==0) {
		$erroradminkey = "The key can't be empty.";
	} else {
		editKey("adminKey",$Pa3);
	}
}
if (isset($_POST['masterKey'])) {
	$te = htmlspecialchars($_POST['masterKey']);
	if (strlen($te)==8) {
		editKey("getMasterKey",$te);
	} else {
		$errormasterkey = "The master key can have only 8 caracters";
	}
	
}
if (isset($_POST['criptKey'])) {
	$ten = htmlspecialchars($_POST['criptKey']);
	if (strlen($ten)==8) {
		editKey("getCriptKey",$ten);
	} else {
		$errorcriptkey = "The crypt key can have only 8 caracters";
	}
}
if (isset($_POST['hashKey'])) {
	$te = htmlspecialchars($_POST['hashKey']);
	if (strlen($te)!=0) {
		editKey("getHashKey",$te);
	} else {
		$errorhashalgo = "The hash key can't be empty";
	}
	
}
if (isset($_POST['hashalgo'])) {
	$te = htmlspecialchars($_POST['hashalgo']);
	if (strlen($te)!=0) {
		editKey("getHashAlgorithm",$te);
	}
}
if (isset($_POST['removeKey'])) {
	$te = htmlspecialchars($_POST['removeKey']);
	if (strlen($te)!=0) {
		removeKey(explode(" - ",$te)[0],explode(" - ",$te)[1]);
	} else {
		$errorremovekey = "You must select a good key.";
	}
}
if ((isset($_POST['newKey']))) {
	$te = htmlspecialchars($_POST['newKey']);
	$ta = htmlspecialchars($_POST['sheetInput']);
	$tu = htmlspecialchars($_POST['Type']);
	if ((strlen($te)!=0) AND (strlen($ta)!=0) AND (strlen($tu)!=0)) {
		addKey($ta."-".$te,$tu);
	} else {
		$errornewkey = "You can't have a argument empty";
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
   			 		<h2>Admin Panel</legend>
   			 	</div>
   				<div class="form-group">
      				<label for="adminKey" class="col-lg-2 control-label">Admin Key</label>
      				<div class="col-lg-10">
                <?php 
                if (isset($erroradminkey)) {
                  echo '<div class="form-group has-error">';
                  echo '<label class="control-label" for="criptKey">'.$erroradminkey.'</label>';
                  echo '<input type="text" class="form-control" id="adminKey" value="'.getKey("adminKey").'" name="adminKey" placeholder="Admin Key">';
                  echo '</div>';
                } else {
                  echo '<input type="text" class="form-control" id="adminKey" value="'.getKey("adminKey").'" name="adminKey" placeholder="Admin Key">';
                }
                ?>
      				</div>
    			</div>
    			<div class="form-group">
      				<label for="criptKey" class="col-lg-2 control-label">Crypt Key</label>
      				<div class="col-lg-10">
      					<?php 
      					if (isset($errorcriptkey)) {
      						echo '<div class="form-group has-error">';
  						    echo '<label class="control-label" for="criptKey">'.$errorcriptkey.'</label>';
  						    echo '<input type="text" class="form-control" id="criptKey" value="'.getKey("getCriptKey").'" name="criptKey" placeholder="Crypt Key">';
						      echo '</div>';
      					} else {
      						echo '<input type="text" class="form-control" id="criptKey" value="'.getKey("getCriptKey").'" name="criptKey" placeholder="Crypt Key">';
      					}
      					?>
    				</div>
    			</div>
    			<div class="form-group">
      				<label for="masterKey" class="col-lg-2 control-label">Master Key</label>
      				<div class="col-lg-10">
                <?php 
                if (isset($errormasterkey)) {
                  echo '<div class="form-group has-error">';
                  echo '<label class="control-label" for="masterKey">'.$errormasterkey.'</label>';
                  echo '<input type="text" class="form-control" id="masterKey" value="'.getKey("getMasterKey").'" name="masterKey" placeholder="Master Key">';
                  echo '</div>';
                } else {
                  echo '<input type="text" class="form-control" id="masterKey" value="'.getKey("getMasterKey").'" name="masterKey" placeholder="Master Key">';
                }
                ?>
    				</div>
    			</div>
    			<div class="form-group">
      				<label for="hashKey" class="col-lg-2 control-label">Hash Key</label>
      				<div class="col-lg-10">
                <?php 
                if (isset($errorhashalgo)) {
                  echo '<div class="form-group has-error">';
                  echo '<label class="control-label" for="hashKey">'.$errorhashalgo.'</label>';
                  echo '<input type="text" class="form-control" id="hashKey" value="'.getKey("getHashKey").'" name="hashKey" placeholder="Hash Key">';
                  echo '</div>';
                } else {
                  echo '<input type="text" class="form-control" id="hashKey" value="'.getKey("getHashKey").'" name="hashKey" placeholder="Hash Key">';
                }
                ?>
    				</div>
    			</div>
    		</div>
   			<div class="form-group">
     			 <label for="hashalgo" class="col-lg-2 control-label">Hashing Algoritm</label>
     			 <div class="col-lg-10">
			        <select class="form-control" id="hashalgo">
              <?php 
                $dts = getKey("getHashAlgorithm");
                if ($dts=="sha256") {
                  echo "<option>sha256</option>";
                  echo "<option>sha512</option>";
                  echo "<option>md5</option>";
                } else if ($dts=="sha512") {
                  echo "<option>sha512</option>";
                  echo "<option>sha256</option>";
                  echo "<option>md5</option>";
                } else if ($dts=="md5") {
                  echo "<option>md5</option>";
                  echo "<option>sha256</option>";
                  echo "<option>sha512</option>";
                }
              ?>
			        </select>
        			<br>
     			 </div>
   			 </div>
   			 <div class="form-group">
      			<div class="col-lg-10 col-lg-offset-2">
        			<button type="reset" class="btn btn-default">Cancel</button>
        			<button type="submit" class="btn btn-primary">Submit</button>
      			</div>
    		</div>
  		</fieldset>
	</form>
	<form class="form-horizontal" method="POST">
  		<fieldset>
  				<div align="center">
   			 		<h2>Add Key</legend>
   			 	</div>
   				<div class="form-group">
      				<label for="newKey" class="col-lg-2 control-label">Key Tag</label>
      				<div class="col-lg-10">
        				<input type="text" class="form-control" id="newKey" name="newKey" placeholder="Key Tag (recomanded size is 32 caracters)" name="newKey">
      				</div>
    			</div>
    			<div class="form-group">
      				<label for="sheetInput" class="col-lg-2 control-label">Sheet</label>
      				<div class="col-lg-10">
        				<input type="text" class="form-control" id="sheetInput" name="sheetInput" placeholder="name of sheet or all">
    				</div>
    			</div>
    		</div>
   			<div class="form-group">
     			 <label for="Type" class="col-lg-2 control-label">Type</label>
     			 <div class="col-lg-10">
			        <select class="form-control" id="Type" name="Type">
			        	<option>Put</option>
			        	<option>Get</option>
			        	<option>Exists</option>
			        </select>
        			<br>
     			 </div>
   			 </div>
   			 <div class="form-group">
      			<div class="col-lg-10 col-lg-offset-2">
        			<button type="reset" class="btn btn-default">Cancel</button>
        			<button type="submit" class="btn btn-primary">Submit</button>
      			</div>
    		</div>
  		</fieldset>
	</form>
	<form class="form-horizontal" method="POST">
  		<fieldset>
  				<div align="center">
   			 		<h2>Remove Key</legend>
   			 	</div>
   			 	<div class="form-group">
     			 <label for="removekey" class="col-lg-2 control-label">Key</label>
     			 <div class="col-lg-10">
			        <select class="form-control" id="removekey" name="removeKey">
			        	<?php
			        		foreach(explode(',',getKeysBy("Get")) as $token) {
			        			echo '<option>'.str_replace('"', '', $token)." - "."Get</option>";
			        		}
			        		foreach(explode(',',getKeysBy("Put")) as $token) {
			        			echo '<option>'.str_replace('"', '', $token)." - "."Put</option>";
			        		}
			        		foreach(explode(',',getKeysBy("Exists")) as $token) {
			        			echo '<option>'.str_replace('"', '', $token)." - "."Exists</option>";
			        		}
			        	?>
			        </select>
        			<br>
     			 </div>
   			 <div class="form-group">
      			<div class="col-lg-10 col-lg-offset-2">
        			<button type="reset" class="btn btn-default">Cancel</button>
        			<button type="submit" class="btn btn-primary">Submit</button>
      			</div>
    		</div>
  		</fieldset>
	</form>
	</body>
</html>