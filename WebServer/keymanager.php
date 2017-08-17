<?php 
include "database.php";
//include "keys.php";

function getSLignes($data) {
	return explode("\r", file_get_contents($data));
}

function getKeys($method) {
	$db = false;
	foreach (getSLignes("keys.php") as $token) {
		$token=$token."\r";
		if (!$db) {
			if (contains($token,"function get".$method."Key() {")) {
				$db=true;
			}
		} else {
			print_r(explode(")",explode("(",$token)[1])[0]);
			return;
		}
	}
	return "can't find ".$method;
}

function removeKey($key,$method) {
	$file = array();
	$db = false;
	foreach (getSLignes("keys.php") as $token) {
		$token=$token."\r";
		if (!$db) {
			if (contains($token,"function get".$method."Key() {")) {
				array_push($file,$token);
				$db=true;
			} else {
				array_push($file,$token);
			}
		} else {
			array_push($file,str_replace(",)",")",str_replace("(,","(",str_replace(",,",",",str_replace("\"".$key."\"","",$token)))));
			$db=false;
		}
	}
	file_put_contents("keys.php",$file);
}

function addKey($key,$method) {
	$file = array();
	$db = false;
	foreach (getSLignes("keys.php") as $token) {
		$token=$token."\r";
		if (!$db) {
			if (contains($token,"function get".$method."Key() {")) {
				array_push($file,$token);
				$db=true;
			} else {
				array_push($file,$token);
			}
		} else {
			if (contains($token,"return array();")) {
				array_push($file,"return array(\"".$key."\");\r");
			} else {
				array_push($file,(explode(');',$token)[0]).",\"".$key."\");\r");
			}
			$db=false;
		}
	}
	file_put_contents("keys.php",$file);
}

function editKey($aquerier,$key) {
	$file=array();
	$db = false;
	foreach (getSLignes("keys.php") as $token) {
		$token=$token."\r";
		if (!$db) {
			if (contains($token,"function ".$aquerier."() {")) {
				array_push($file,$token);
				$db=true;
			} else {
				array_push($file,$token);
			}
		} else {
			array_push($file,"	return \"".$key."\";\r");
			$db=false;
		}
	}
	file_put_contents("keys.php",$file);
}

function getKey($aquerier) {
	$db = false;
	foreach (getSLignes("keys.php") as $token) {
		$token=$token."\r";
		if (!$db) {
			if (contains($token,"function ".$aquerier."() {")) {
				$db=true;
			}
		} else {
			return (explode("\"",$token)[1]);
		}
	}
}

$type = htmlspecialchars($_GET['type']);
$apikey = htmlspecialchars($_GET['apikey']);
$executor = htmlspecialchars($_GET['executor']);
if ($apikey!=adminKey()) {
	print_r("invalid key");
	return;
}
if ($type=="EditKeyArray") {
	$method = htmlspecialchars($_GET['method']);
	if ($method=="remove") {
		$key = htmlspecialchars($_GET['key']);
		removeKey($key,$executor);
	} else if ($method=="add") {
		$key = htmlspecialchars($_GET['key']);
		addKey($key,$executor);
	} else if ($method=="get") {
		print_r(getKeys($executor));
	}
} else if ($type=="EditKey") {
	$method = htmlspecialchars($_GET['method']);
	if ($method=="set") {
		$key = htmlspecialchars($_GET['key']);
		editKey($executor,$key);
	} else if ($method=="get") {
		print_r(getKey($executor));
	}
}
?>