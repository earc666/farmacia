<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


require('../class/marcaModel.php');
require('../class/config.php');
//creamos una instancia de la clase rolModel
$marcas = new marcaModel;
$marc = $marcas->getMarcas();
//print_r($marc);
if (isset($_SESSION['autenticado']) && $_SESSION['rol']=='ADMINISTRADOR'): ?>

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Marcas</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Marcas</h3>
				   			<?php include ('../partials/mensajes.php'); ?>
				
				<a href="addMarcas.php" class="btn btn-primary">Nueva Marca</a>
				<?php if(isset($marc) && count($marc)): ?>
					<table class="table table-hover">
						<?php foreach($marc as $ma): ?>
							<tr>
								<td>

								<a href="verMarca.php?id=<?php echo $ma['id']; ?>"><?php echo $ma['nombre']; ?></a>								 	
								 </td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php else: ?>
					<p class="text-info mt-3">No hay Marcas registradas</p>
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