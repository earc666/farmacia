<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


require('../class/rolModel.php');
require('../class/config.php');
//creamos una instancia de la clase rolModel
$roles = new rolModel;

if (isset($_GET['id'])) {
	$id = (int) $_GET['id'];

	//preguntamos si existe datos asociados al id
	$res = $roles->getRolId($id);

	if ($res) {
		//eliminar
		$sql = $roles->deleteRoles($id);

		if ($sql) {
			$msg = 'ok';
			header('Location: roles.php?mg=' . $msg);
		}else{
			$msg = 'error';
			header('Location: roles.php?er=' . $msg);
		}

	}else{
		$msg = 'error';
		header('Location: roles.php?e=' . $msg);
	}
}