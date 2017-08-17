<?php
include "keys.php";

function Ecript($data,$keydata) {
    $key = $keydata;  // Clé de 8 caractères max
    $data = serialize($data);
    $td = mcrypt_module_open(MCRYPT_DES,"",MCRYPT_MODE_ECB,"");
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td,$key,$iv);
    $data = base64_encode(mcrypt_generic($td, '!'.$data));
    mcrypt_generic_deinit($td);
    return $data;
}

function encrypt($data) {
	return Ecript(Ecript($data,getCriptKey()),getMasterKey());
}

function Dcript($data,$keydata) {
    $key = $keydata;
    $td = mcrypt_module_open(MCRYPT_DES,"",MCRYPT_MODE_ECB,"");
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td,$key,$iv);
    $data = mdecrypt_generic($td, base64_decode($data));
    mcrypt_generic_deinit($td);
 
    if (substr($data,0,1) != '!')
        return false;
 
    $data = substr($data,1,strlen($data)-1);
    return unserialize($data);
}

function decrypt($data) {
	return Dcript(Dcript($data,getMasterKey()),getCriptKey());
}

function getPutLignes($sheet) {
	if (!file_exists("data/".$sheet.'.pdb')) {
		$myfile = fopen("data/".$sheet.'.pdb', "w") or die("Unable to open file!");
		fclose($myfile);
	}
	return explode("\n", file_get_contents("data/".$sheet.'.pdb'));
}

function getLignes($sheet) {
	if (!file_exists("data/".$sheet.'.pdb')) {
		print_r("file don't exist");
	}
	return explode("\n", file_get_contents("data/".$sheet.'.pdb'));
}

function hasher($text) {
	return hash('md5',hash("sha512",$text."@pdb#".getHashKey()));
}

function getData($apikey,$sheet,$key) {
	if (!isGetKeyValid($sheet,$apikey)) {
		return "invalid key";
	}
	foreach (getLignes($sheet) as $token) {
		if (contains($token,hasher($key).": ")) {
			return decrypt(explode(": ",$token)[1]);
		}
	}
	return "not found";
}

function putData($apikey,$sheet,$key,$value) {
	if (!isPutKeyValid($sheet,$apikey)) {
		return "invalid key";
	}
	$array = array();
	foreach (getPutLignes($sheet) as $token) {
		if (!contains($token,hasher($key).": ")) {
			if (strlen(trim($token))!=0) {
				array_push($array,$token."\n");
				print_r("data");
			}
		}
	}
	array_push($array,hasher($key).": ".encrypt($value)."\n");
	file_put_contents("data/".$sheet.".pdb",$array);
	return "ok";
}

function existsData($apikey,$sheet,$key) {
	if (!isExistsKeyValid($sheet,$apikey)) {
		return "invalid key";
	}
	foreach (getLignes($sheet) as $token) {
		if (contains($token,hasher($key).": ")) {
			return true;
		}
	}
	return false;
}

function isGetKeyValid($sheet,$key) {
	foreach (getGetKey() as $token) {
		if (contains($token, "all-".$key)) {
			return true;
		}
		if (contains($token, $sheet."-".$key)) {
			return true;
		}
	}
	return false;
}

function isPutKeyValid($sheet,$key) {
	foreach (getPutKey() as $token) {
		if (contains($token, "all-".$key)) {
			return true;
		}
		if (contains($token, $sheet."-".$key)) {
			return true;
		}
	}
	return false;
}

function isExistsKeyValid($sheet,$key) {
	foreach (getExistsKey() as $token) {
		if (contains($token, "all-".$key)) {
			return true;
		}
		if (contains($token, $sheet."-".$key)) {
			return true;
		}
	}
	return false;
}

function contains($body,$container) {
	return (strpos($body,$container) !== false);
}
?>