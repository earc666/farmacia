<?php
require_once('modelo.php');

class categoriaModel extends Modelo
{
	public function __construct(){
		//disponemos de lo declarado en el constructor de la clase modelo
		parent::__construct();
	}

	//traemos todos los categorias de la tabla categorias
	public function getCategorias(){
		//consulta a la tabla categorias usando el objeto db de la clase modelo
		$categorias = $this->_db->query("SELECT id, codigo, nombre FROM categorias ORDER BY nombre");

		//retornamos lo que haya en la tabla categorias
		return $categorias->fetchall();
	}

	public function getCategoriaId($id){
		$id = (int) $id;

		$categoria = $this->_db->prepare("SELECT id, codigo, nombre, created_at, updated_at FROM categorias WHERE id = ?");
		$categoria->bindParam(1, $id);
		$categoria->execute();

		return $categoria->fetch();
	}

	public function getcategoriaNombre($nombre){
		$categoria = $this->_db->prepare("SELECT id FROM categorias WHERE nombre = ?");
		$categoria->bindParam(1, $nombre);
		$categoria->execute();

		return $categoria->fetch();
	}
	public function getcategoriaCodigo($codigo){
		$categoria = $this->_db->prepare("SELECT id FROM categorias WHERE codigo = ?");
		$categoria->bindParam(1, $codigo);
		$categoria->execute();

		return $categoria->fetch();
	}

	public function setcategorias($codigo, $nombre){
		$categoria = $this->_db->prepare("INSERT INTO categorias VALUES(null, ?, ?, now(), now())");
		$categoria->bindParam(1, $codigo);
		$categoria->bindParam(2, $nombre); //definimos el valor de cada ?
		$categoria->execute();//ejecutamos la consulta

		$row = $categoria->rowCount(); //devuelve la cantidad de registros insertados
		return $row;
	}

	//metodo para actualizar o modificar categorias
	public function editcategorias($id, $codigo, $nombre){
		//print_r($nombre);exit;
		$id = (int) $id;

		$categoria = $this->_db->prepare("UPDATE categorias SET codigo=?, nombre = ?, updated_at = now() WHERE id = ?");
		$categoria->bindParam(1, $codigo);
		$categoria->bindParam(2, $nombre);
		$categoria->bindParam(3, $id);
		$categoria->execute();

		$row = $categoria->rowCount(); //devuelve la cantidad de registros modificadas
		//print_r($row);exit;
		return $row;
	}


}
