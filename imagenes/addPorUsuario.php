<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/imagenModel.php');
require('../class/usuarioModel.php');
require('../class/config.php');
//creamos las instancias para agregar un usuario

$imagenes = new imagenModel;
$usuarios = new usuarioModel;

//recepcion del id del usuario
if (isset($_GET['id'])) {
	$usuario = (int) $_GET['id'];
	//print_r($usuario);exit;

	$usu = $usuarios->getUsuarioId($usuario);

	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
		$titulo = trim(strip_tags($_POST['titulo']));
		$descripcion = trim(strip_tags($_POST['descripcion']));
		$portada = (int) $_POST['portada'];

		//print_r($_POST);exit;
		//recibir el nombre original del archivo
		$imagen = $_FILES['imagen']['name'];

		//el nombre y directorio temporal
		$tmp_name = $_FILES['imagen']['tmp_name'];

		//pendientes las validaciones

		// Guardamos la ruta donde almacenaremos la imagen
$upload = $_SERVER['DOCUMENT_ROOT'] . '/farmacia/img/usuarios/';
	//Guardamos el directorio y el archivo en una variable
		$fichero_subido = $upload . basename($_FILES['imagen']['name']);

		//Validamos si el archivo se halla en el directorio escogido
		if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)){

			$sql = $imagenes->setImagenusuario($titulo, $descripcion, $imagen, $usuario, $portada);
			if (!$sql) {
				$mensaje = 'La imagen no se ha registrado correctamente';
			}else{
				$_SESSION['success'] = 'La imagen se ha registrado correctamente';
				header('Location: ' . BASE_URL . 'usuarios/verusuario.php?id=' . $usuario);
			}
		}else{
			$mensaje = 'La imagen no ha podido ser cargada en el servidor';
		}
	}
}
//print_r($_SESSION['rol']);exit;

if(isset($_SESSION['autenticado']) && $_SESSION['rol'] == 'ADMINISTRADOR'):
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nueva Imagen</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Nueva Imagen</h3>
				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>
				<p class="text-danger">Si tiene un asterisco es obligatorio</p>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label><h5 class="text-info">Usuario: <?php echo $usu['usuario']; ?></h5></label>
					</div>
					<div class="form-group">
						<label>Título<span class="text-danger">*</span></label>
						<input type="text" name="titulo" value="<?php echo @($titulo); ?>" placeholder="Título de la imagen" class="form-control">
					</div>
					<div class="form-group">
						<label>Descripción</label>
						<textarea name="descripcion" class="form-control" rows="4" style="resize: none">
							<?php echo @($descripcion); ?>
						</textarea>
					</div>
					<div class="form-group">
						<label>Portada<span class="text-danger">*</span></label>
						<select name="portada" class="form-control">
							<option value="">Seleccione...</option>
							<option value="1">Si</option>
							<option value="2">No</option>
						</select>
					</div>
					<div class="form-group">
						<label>Imagen<span class="text-danger">*</span></label>
						<input type="file" name="imagen" class="form-control">
					</div>
					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Guardar</button>
						<a href="<?php echo BASE_URL . 'usuarios/verusuario.php?id=' . $usuario; ?>" class="btn btn-link">Volver</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
<?php else:
	header('Location: ' . BASE_URL . 'index.php');
	endif;
?>