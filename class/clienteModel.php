<?php
require_once('modelo.php');

class clienteModel extends Modelo{

	public function __construct(){
		//disponemos de lo declarado en el constrcctor de la clase modelo
		parent::__construct();
	}

	//metodo qce mcestra todos los clientes
	public function getClientes(){
		$cli = $this->_db->query("SELECT  c.id, c.nombre as cliente, c.rut, c.active FROM clientes c");

		return $cli->fetchall();
	}

	//metodo qce mcestra cn cliente por id
	public function getClienteId($id){
		$id = (int) $id;

		$cli = $this->_db->prepare("SELECT c.id, c.nombre as cliente, c.direccion, c.active, c.rut, c.persona, c.fecha_nac, c.created_at, c.updated_at FROM clientes c WHERE c.id = ?");
		$cli->bindParam(1, $id);
		$cli->execute();

		return $cli->fetch();
	}
	

	//metodo qce verifica qce cn cliente este registrado
	public function getClienteRut($rut){
		$cli = $this->_db->prepare("SELECT id FROM clientes WHERE rut = ?");
		$cli->bindParam(1, $rut);
		$cli->execute();

		return $cli->fetch();
	}


	//metodo para insertar clientes
	public function setcliente($nombre, $rut, $direccion, $fecha_nac, $persona){
		$persona = (int) $persona;

		//activo = 1 y 2 = inactivo

		$cli = $this->_db->prepare("INSERT INTO clientes VALUES(null, ?, ?, ?, ?, ?,  1, now(), now())");
		$cli->bindParam(1, $nombre);
		$cli->bindParam(2, $rut);
		$cli->bindParam(3, $direccion);
		$cli->bindParam(4, $fecha_nac);
		$cli->bindParam(5, $persona);
		$cli->execute();

		$row = $cli->rowCount();
		return $row;
	}

	//metodo para editar cliente
	public function editCliente($id, $nombre, $rut, $direccion, $fecha_nac, $persona, $active){
		$active = (int) $active;
		$persona = (int) $active;
		$cli = $this->_db->prepare("UPDATE clientes SET nombre = ?, rut = ?, direccion = ?, fecha_nac = ?,  persona = ?,  active = ?, updated_at = now() WHERE id = ?");
		$cli->bindParam(1, $nombre);
		$cli->bindParam(2, $rut);
		$cli->bindParam(3, $direccion);
		$cli->bindParam(4, $fecha_nac);
		$cli->bindParam(5, $persona);
		$cli->bindParam(6, $active);
		$cli->bindParam(7, $id);
		$cli->execute();

		$row = $cli->rowCount();
		return $row;
	}

	//metodo para cambiar password
	public function editPassword($id, $clave){
		$id = (int) $id;
		$clave = sha1($clave);

		$cli = $this->_db->prepare("UPDATE clientes SET password = ? WHERE id = ?");
		$cli->bindParam(1, $clave);
		$cli->bindParam(2, $id);
		$cli->execute();

		$row = $cli->rowCount();
		return $row;
	}






}