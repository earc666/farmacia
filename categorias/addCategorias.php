<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


require('../class/categoriaModel.php');
require('../class/config.php');
$categorias = new categoriaModel;

//print_r($categ);
if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
	$nombre = trim(strip_tags($_POST['nombre']));
	$codigo=trim(strip_tags($_POST['codigo']));

	if (!$nombre OR !$codigo) {
		$mensaje = 'Ambos datos son necesarios para ingresar la nueva categoria';
	}else{

		$categ = $categorias->getcategoriaNombre($nombre);

		if ($categ) {
			$mensaje = 'La categoria ingresada ya existe';
		}else{
		$categ = $categorias->getcategoriaCodigo($codigo);		
			if ($categ) {
				$mensaje='EL codigo ingresado ya existe';
			}else{
			$categ = $categorias->setCategorias($codigo,$nombre);

			if ($categ) {
				$_SESSION['success'] = 'La categoria se ha registrado correctamente';
				$msg = 'ok';
				header('Location: categorias.php?m=' . $msg);
			}else{
				$_SESSION['danger'] = 'La categoria no se ha resgistrado correctamente';
			}
		}
	}
}
}
if(isset($_SESSION['autenticado']) &&( $_SESSION['rol'] == 'ADMINISTRADOR' ||  $_SESSION['rol'] == 'SUPERVISOR'  )):

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nueva Categoria</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Nueva Categoria</h3>
				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>

				<form action="" method="post">
					<div class="form-group">
						<label>Nombre de la categoria</label>
						<input type="text" name="nombre" value="<?php echo @($nombre); ?>" placeholder="Nombre de la categoria" class="form-control">
					</div>
					<div class="form-group">
						<label>Codigo de la categoria</label>
						<input type="text" name="codigo" value="<?php echo @($codigo); ?>" placeholder="Codigo de la categoria" class="form-control">
					</div>
					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Guardar</button>
						<a href="categorias.php" class="btn btn-link">Volver</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
<?php else: 
header('Location: '   .BASE_URL . 'index.php');
 endif; 
 ?>