<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


require('../class/clienteModel.php');
require('../class/config.php');

//creamos una instancia de la clase rolModel
$clientes = new clienteModel();

//print_r($_GET);

if (isset($_GET['id'])) {
	//recuperamos y sanitizamos el dato que viene por cabecera
	$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
	//$id = (int) $id;

	$cli = $clientes->getClienteId($id);

	if (!$cli) {
	
	$_SESSION['danger'] = "El cliente no existe";

		$msg = 'error';
		header('Location: clientes.php?e=' . $msg);
	}
}
//print_r($cli);
if (isset($_SESSION['autenticado']) && $_SESSION['rol']=='ADMINISTRADOR'): ?>

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>cliente</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>cliente</h3>
				<!--Valida o notifica que el registro se ha realizado-->
				<?php include('../partials/mensajes.php'); ?>

				<table class="table table-hover">
					<tr>
						<th>Nombre:</th>
						<td><?php echo $cli['cliente']; ?></td>
					</tr>
					<tr>
						<th>Rut:</th>
						<td><?php echo $cli['rut']; ?></td>
					</tr>
					<tr>
						<th>Direccion:</th>
						<td><?php echo $cli['direccion']; ?></td>
					</tr>
					<tr>
						<th>Nacimiento:</th>
						<td><?php echo $cli['fecha_nac']; ?></td>
					</tr>
					<tr>
						<th>Tipo Cliente:</th>
						<td>
							<?php
								if($cli['persona'] == 1): ?>
									Persona Natural
								<?php else: ?>
									Ortro
								<?php endif; ?>
						</td>
					<tr>
						<th>Activo:</th>
						<td>
							<?php
								if($cli['active'] == 1): ?>
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
								$fecha_reg = new DateTime($cli['created_at']);
								echo $fecha_reg->format('d-m-Y H:i:s');
							?>
						</td>
					</tr>
					<tr>
						<th>Fecha de modificación:</th>
						<td>
							<?php
								$fecha_mod = new DateTime($cli['updated_at']);
								echo $fecha_mod->format('d-m-Y H:i:s');
							?>
						</td>
					</tr>
				</table>
				<p>
					<a href="editcliente.php?id=<?php echo $cli['id']; ?>" class="btn btn-link">Editar</a>
					<a href="clientes.php" class="btn btn-link">Volver</a>
					<a href="#" class="btn btn-danger">Eliminar</a>
				</p>
			</div>
		</div>
	</div>
</body>
</html>
<?php else: 
header('Location: '   .BASE_URL . 'index.php');
 endif; 
 ?>