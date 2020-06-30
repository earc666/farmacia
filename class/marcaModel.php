<?php
require_once('modelo.php');

class marcaModel extends Modelo
{
	public function __construct(){
		parent::__construct();
	} 
	//traemos todos las marcas de la tabla marcas
	public function getMarcas(){
		//consulta a la tabla marcas usando el objeto db de la clase modelo, los ordene por nombre
		$marcas = $this->_db->query("SELECT id, nombre FROM marcas ORDER BY nombre");

		//retornamos lo que haya en la tabla marcas
		return $marcas->fetchall();
	}

	public function getmarcaId($id){
		$id = (int) $id;

		$marca = $this->_db->prepare("SELECT id, nombre, created_at, updated_at FROM marcas WHERE id = ?");
		$marca->bindParam(1, $id);
		$marca->execute();

		return $marca->fetch();
	}

	//verificar el registro previo de una marca
	public function getMarcaNombre($nombre){
		$marca = $this->_db->prepare("SELECT id FROM marcas WHERE nombre = ?");
		$marca->bindParam(1, $nombre);
		$marca->execute();

		return $marca->fetch();
	}

	public function setMarcas($nombre){
		$marca = $this->_db->prepare("INSERT INTO marcas VALUES(null, ?, now(), now())");
		$marca->bindParam(1, $nombre); //definimos el valor de cada ?
		$marca->execute();//ejecutamos la consulta

		$row = $marca->rowCount(); //devuelve la cantidad de registros insertados
		return $row;
	}

	//metodo para actualizar o modificar marcas
	public function editMarcas($id, $nombre){
		//print_r($nombre);exit;
		$id = (int) $id;

		$marca = $this->_db->prepare("UPDATE marcas SET nombre = ?, updated_at = now() WHERE id = ?");
		$marca->bindParam(1, $nombre);
		$marca->bindParam(2, $id);
		$marca->execute();

		$row = $marca->rowCount(); //devuelve la cantidad de registros modificadas
		//print_r($row);exit;
		return $row;
	}

	//metodo para eliminar marcasm al final no l implemente teniendo en cuenta lo conversado en clase al respecto de mantener la seguridad e integridad de la base de datos.
	public function deleteMarcas($id){
		$id = (int) $id;

		$Marca = $this->_db->prepare("DELETE FROM Marcas WHERE id = ?");
		$Marca->bindParam(1, $id);
		$Marca->execute();

		$row = $Marca->rowCount();
		return $row;
	}
}
