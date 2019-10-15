<?php 

class Usuario {
	private $id_user;
	private $login_user;
	private $senha_user;
	private $dt_cadastro;

	public function getIdusuario(){
		return $this->id_user;
	}
	public function setIdusuario($value){
		$this->id_user = $value;
	}
	public function getLogin(){
		return $this->login_user;
	}
	public function setLogin($value){
		$this->login_user = $value;
	}
	public function getSenha(){
		return $this->senha_user;
	}
	public function setSenha($value){
		$this->senha_user = $value;
	}
	public function getCadastro(){
		return $this->dt_cadastro;
	}
	public function setCadastro($value){
		$this->dt_cadastro = $value;
	}

	public function loadById($id){
		$sql = new sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE id_user = :ID", array(":ID"=>$id));

		if(count($results)>0){

			$row = $results[0];
			$this->setIdusuario($row['id_user']);
			$this->setLogin($row['login_user']);
			$this->setSenha($row['senha_user']);
			$this->setCadastro(new DateTime($row['dt_cadastro']));
		}
	}

	public static function getList(){

		$sql = new sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY login_user");
	}

	public static function search($login){

		$sql = new sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE login_user LIKE :SEARCH ORDER BY id_user",
			array(':SEARCH'=>"%".$login."%"));
	}

	public function login($login, $password){
		
		$sql = new sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE login_user = :LOGIN AND senha_user = :PASSWORD",array(":LOGIN"=>$login, ":PASSWORD"=>$password));

		if(count($results) > 0){
			$row = $results[0];
			$this->setIdusuario($row['id_user']);
			$this->setLogin($row['login_user']);
			$this->setSenha($row['senha_user']);
			$this->setCadastro(new DateTime($row['dt_cadastro']));
		} else{
			throw new Exception("Login e/ou senha inválidos!");
			
		}

	}

	public function __toString(){

		return json_encode(array(
			"id_user"=>$this->getIdusuario(),
			"login_user"=>$this->getLogin(),
			"senha_user"=>$this->getSenha(),
			"dt_cadastro"=>$this->getCadastro()->format("d/m/Y H:i:s")
		));
	}

}
 ?>
