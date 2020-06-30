<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/clienteModel.php');
require('../class/config.php');

$clientes = new clienteModel;
$cli = $clientes->getClientes();
//print_r($cli);
if (isset($_SESSION['autenticado']) && $_SESSION['rol']=='ADMINISTRADOR'): ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>clientes</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-8 mt-3">
				<h3>clientes</h3>
					
					 <?php include ('../partials/mensajes.php'); ?>
 			
				<a href="addclientes.php" class="btn btn-primary">Nuevo cliente</a>
				<?php if(isset($cli) && count($cli)): ?>
					<table class="table table-hover">
						<tr>
							<th>Cliente</th>
							<th>Rut</th>
							<th>Activo</th>
						</tr>
						<?php foreach($cli as $c): ?>
							<tr>
								<td>
									<a href="vercliente.php?id=<?php echo $c['id']; ?>"><?php echo $c['cliente']; ?></a>
								</td>
								<td><?php echo $c['rut'] ?></td>
								<td>
									<?php if($c['active'] == 1): ?>
										Si
									<?php else: ?>
										No
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php else: ?>
					<p class="text-info mt-3">No hay clientes registrados</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</body>
</html>
<?php else: 
header('Location: '   .BASE_URL . 'index.php');
 endif; 
 ?>