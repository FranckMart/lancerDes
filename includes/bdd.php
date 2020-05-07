
<?php


require_once("config.php");


try{
	$bdd = new PDO("mysql:host=".$host.";dbname=".$dbname, $userBdd, $passBdd);
	$GLOBALS['bdd'] = $bdd;
	$bdd->exec('SET NAMES utf8');
	

} catch (Exception $exception) {
	$messageError = $exception->getMessage();
}