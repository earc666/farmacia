<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


require('../class/marcaModel.php');
require('../class/categoriaModel.php');
require('../class/productoModel.php');
require('../class/config.php');


//creamos una instancia de la clase rolModel y usuarioModel
$marcas = new marcaModel;
$categorias = new categoriaModel;
$productos = new productoModel;

//print_r($pro);
if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
	$codigo = trim(strip_tags($_POST['codigo']));
	$nombre = trim(strip_tags($_POST['nombre']));
	$descripcion = trim(strip_tags($_POST['descripcion']));
	$precio = (int) $_POST['precio'];
	$categoria = (int) $_POST['categoria'];
	$marca = (int) $_POST['marca'];
	

	if (!$nombre) {
		$mensaje = 'Ingrese el nombre del Producto';
		}elseif (!$codigo) {
		$mensaje = 'Ingrese el codigo del producto';
		}elseif (!$descripcion) {
		$mensaje = 'Ingrese la descripcion del producto';
	}elseif (!$categoria) {
		$mensaje = 'Seleccione la categoria del producto';
	}elseif (!$marca) {
		$mensaje = 'Seleccione la marca del producto';
	}elseif (!$precio) {
		$mensaje = 'indique el precio del producto';
		}else{
			
		// verificar que el producto no se haya registrado previamente, me parecio importante en este punto verificar el codigo con el que se registra esto dado que si se analiza, los nombres si pueden repetirse en muchos medicamentos, por ende deberia verificarse otro dato.
		$pro = $productos->getProductoCodigo($codigo);

		if ($pro) {
			$mensaje = 'El producto ingresado ya existe';
		}
		else{
		

			$prod = $productos->setProducto($nombre, $codigo, $precio, $categoria, $marca, $descripcion);

			print_r($pro);

			if ($prod) {
				 $_SESSION['success']='El producto se ha registrado correctamente';
				 header('Location: productos.php?m=' . $msg);
			}else{
				$mensaje='NO CORRECTO';
				$_SESSION['danger']='El producto no se ha registrado';

				header('Location: productos.php?e=' . $msg);
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
	<title>Nuevo Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Nuevo Producto</h3>
				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>
				<form action="" method="post">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="nombre" value="<?php echo @($nombre); ?>" placeholder="Nombre del Producto" class="form-control">
					</div>
					<div class="form-group">
						<label>Codigo</label>
						<input type="text" name="codigo" value="<?php echo @($codigo); ?>" placeholder="Codigo del Producto" class="form-control">
					</div>
					<div class="form-group">
						<label>Descripcion</label>
						<input type="text" name="descripcion" value="<?php echo @($descripcion); ?>" placeholder="Descripcion del Producto" class="form-control">
					</div>
					<div class="form-group">
						<label>Precio</label>
						<input type="text" name="precio" value="<?php echo @($precio); ?>" placeholder="Precio del Producto" class="form-control">
					</div>
					<div c
					<div class="form-group">
						<label>Marca</label>
						<select name="marca" class="form-control">
							<option value="">Seleccione...</option>
							<?php
								$mar = $marcas->getMarcas();
								foreach($mar as $m):
							?>
								<option value="<?php echo $m['id']; ?>"><?php echo $m['nombre']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Categoria</label>
						<select name="categoria" class="form-control">
							<option value="">Seleccione...</option>
							<?php
								$cat = $categorias->getCategorias();
								foreach($cat as $c):
							?>
								<option value="<?php echo $c['id']; ?>"><?php echo $c['nombre']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Guardar</button>
						<a href="productos.php" class="btn btn-link">Volver</a>
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