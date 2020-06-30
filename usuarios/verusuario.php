<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/rolModel.php');
require('../class/usuarioModel.php');
require('../class/imagenModel.php');

$imagenes = new imagenModel;



require('../class/config.php');


$roles = new rolModel;
$usuarios = new usuarioModel;

//print_r($_GET);
if (isset($_GET['id'])) {
	//recuperamos y sanitizamos el dato que viene por cabecera
	$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
	//$id = (int) $id;

	$usu = $usuarios->getUsuarioId($id);

	
	$img = $imagenes->getImagenUsuario($id);
	// echo($img['img_name']);exit;

	if (!$usu) {
		// $_SESSION['danger'] = 'El dato no es válido';
	}
}
	// print_r(BASE_IMG);exit;

// print_r($id); exit;
if(isset($_SESSION['autenticado']) &&( $_SESSION['rol'] == 'ADMINISTRADOR' ||  $_SESSION['rol'] == 'SUPERVISOR'  )):
 ?>

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Usuario</h3>
				<!--Valida o notifica que el registro se ha realizado-->
				<?php include('../partials/mensajes.php'); ?>

				<table class="table table-hover">
					<tr>
						<th>Nombre:</th>
						<td><?php echo $usu['usuario']; ?></td>
					</tr>
					<tr>
						<th>Email:</th>
						<td><?php echo $usu['email']; ?></td>
					</tr>
					<tr>
						<th>Rol:</th>
						<td><?php echo $usu['rol']; ?></td>
					</tr>
					<tr>
						<th>Activo:</th>
						<td>
							<?php
								if($usu['active'] == 1): ?>
									Si
								<?php else: ?>
									No
								<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>Fecha de creación:</th>
						<td>
							<?php
								$fecha_reg = new DateTime($usu['created_at']);
								echo $fecha_reg->format('d-m-Y H:i:s');
							?>
						</td>
					</tr>
					<tr>
						<th>Fecha de modificación:</th>
						<td>
							<?php
								$fecha_mod = new DateTime($usu['updated_at']);
								echo $fecha_mod->format('d-m-Y H:i:s');
							?>
						</td>
					</tr>
				</table>
				<p>
					<a href="editUsuario.php?id=<?php echo $usu['id']; ?>" class="btn btn-link">Editar</a>
					<a href="usuarios.php" class="btn btn-link">Volver</a>
					<a href="#" class="btn btn-danger">Eliminar</a>
				<a href="<?php echo BASE_URL . 'imagenes/addPorusuario.php?id=' . $usu['id']; ?>" class="btn btn-primary">Agregar Imagen</a>

				</p>
		
		</div>
			<div class="col-md-6 mt-3">
				<h4>Imágenes asociadas a <?php echo $usu['usuario']; ?></h4>
				<?php if(isset($img) && count($img)): ?>
					<?php foreach($img as $img): ?>
						<div class="col-md-6">
							<h5><?php echo $img['titulo']; ?></h5>
							<img style="width: 100%; height: 100%" src="<?php echo BASE_IMG . '/usuarios/' . $img['nombre']; ?>" > 
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<p class="text-info">No hay imágenes asociadas</p>
				<?php endif; ?>
			</div>
	</div>
</body>
</html>
<?php else:
	header('Location: ' . BASE_URL . 'index.php');
	endif;
?>