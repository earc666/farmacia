<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


require('../class/categoriaModel.php');
require('../class/config.php');
$categorias = new categoriaModel();

//print_r($_GET);

if (isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

	$categ = $categorias->getCategoriaId($id);

	if (!$categ) {
	$_SESSION['danger'] = 'La categoria no existe';

		$msg = 'error';
		header('Location: categorias.php?e=' . $msg);
	}

	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
		
		$nombre = trim(strip_tags($_POST['nombre']));
		$codigo = trim(strip_tags($_POST['codigo']));

		if (!$nombre) {
			$mensaje='Ingrese el nombre de la categoria';
		}else{
			if (!$codigo) {
			$mensaje='Ingrese el codigo de la categoria';

			}else{
				$sql = $categorias->editCategorias($id, $codigo, $nombre);
			if ($sql) {
				$msg = 'ok';
				header('Location: verCategoria.php?m=' . $msg . '&id=' . $id);
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
	<title>Rol</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Rol</h3>
				<?php if(isset($_GET['m'])): ?>
					<p class="alert alert-success">La Categoria se ha modificado correctamente</p>
				<?php endif; ?>

				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>

				<form action="" method="post">
					<div class="form-group">
						<label>Nombre de la categoria</label>
						<input type="text" name="nombre" value="<?php echo $categ['nombre']; ?>" placeholder="Nombre del rol" class="form-control">
					</div>
					<div class="form-group">
						<label>Codigo de la categoria</label>
						<input type="text" name="codigo" value="<?php echo $categ['codigo']; ?>" placeholder="codigo de la categoria" class="form-control">
					</div>
					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Modificar</button>
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