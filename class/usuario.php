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
