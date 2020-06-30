<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


require('../class/clienteModel.php');
require('../class/config.php');


$clientes = new clienteModel;



	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
	$nombre = trim(strip_tags($_POST['nombre']));
	$rut = trim(strip_tags($_POST['rut']));
	$direccion = trim(strip_tags($_POST['direccion']));
	$fecha_nac = trim(strip_tags($_POST['fecha_nac']));
	$persona = (int) $_POST['persona'];


	if (!$nombre) {
		$mensaje = 'Ingrese el nombre del cliente';
		}elseif (!$rut) {
		$mensaje = 'Ingrese el rut del cliente';
		// aplique un codigo descargado de la web para validar si el Rut ingresado corresponde, teniendo en cuenta de apicarlo solo para persona natural, paso las pruebas realizadas y lo use con el objetivo de poder verificar cmo se implementaria controles adicionales al ingreso de estos datos.
		}elseif (($persona==1) &&(valida_rut($rut)== false)){

            $mensaje = 'el rut no es correcto';
            
   		}

		elseif (!$direccion) {
		$mensaje = 'Ingrese la direccion del cliente';
	}elseif (!$fecha_nac) {
		$mensaje = 'Seleccione la fecha de nacimiento del cliente';
	}elseif (!$persona) {
		$mensaje = 'Seleccione tipo de cliente del cliente';
		} else {

			 

		$cli = $clientes->getClienteRut($rut);

		if ($cli) {
			$mensaje = 'El Rut ingresado ya esta registrado';
		} else {      
		
		$cli = $clientes->setCliente($nombre, $rut, $direccion, $fecha_nac, $persona);

		   if ($cli) {
				 $_SESSION['success']='El cliente se ha registrado correctamente';
				 header('Location: clientes.php?m=' . $msg);
			}else{
				$mensaje='NO CORRECTO';
				$_SESSION['danger']='El cliente no se ha registrado';

				header('Location: clientes.php?e=' . $msg);
			}
		}
		}
	
}

if (isset($_SESSION['autenticado']) && $_SESSION['rol']=='ADMINISTRADOR'): ?>

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
				<h3>Nuevo cliente</h3>
				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>
				<form action="" method="post">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="nombre" value="<?php echo @($nombre); ?>" placeholder="Nombre del cliente" class="form-control">
					</div>
					<div class="form-group">
						<label>rut</label>
						<input type="text" name="rut" value="<?php echo @($rut); ?>" placeholder="Rut del cliente" class="form-control">
					</div>
					<div class="form-group">
						<label>Direccion</label>
						<input type="text" name="direccion" value="<?php echo @($direccion); ?>" placeholder="direccion del cliente" class="form-control">
					</div>
					<div class="form-group">
						<label>Fecha Nacimiento</label>
						<input type="date" name="fecha_nac" value="<?php echo @($fecha_nac); ?>" placeholder="Fecha nacimiento del cliente" class="form-control">
					</div>
					<div class="form-group">
						<label>Tipo Cliente</label>
						<select name="persona" class="form-control">
							<!-- <option value="<?php echo $cli['active'] ?>"> -->
								<?php if($cli['persona']==1): ?>Persona Natural<?php else: ?> Inactivo <?php endif; ?>
							</option>
							<option value="1">Persona Natural</option>
							<option value="2">Juridica / otro</option>
						</select>
					</div>			
					
					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Guardar</button>
						<a href="clientes.php" class="btn btn-link">Volver</a>
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