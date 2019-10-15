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

			$this->setData($results[0]);
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

			$this->setData($results[0]);
			
		} else{
			throw new Exception("Login e/ou senha inválidos!");
			
		}

	}
	
	public function setData($data){

			$this->setIdusuario($data['id_user']);
			$this->setLogin($data['login_user']);
			$this->setSenha($data['senha_user']);
			$this->setCadastro(new DateTime($data['dt_cadastro']));

	}

	public function insert(){
		$sql = new sql();
		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)",array(
			':LOGIN'=>$this->getLogin(),
			':PASSWORD'=>$this->getSenha()

		));

		if(count($results) >0){
			$this->setData($results[0]);
		}
	}

	public function update($login, $password){

		$this->setLogin($login);
		$this->setSenha($password);

		$sql = new sql();

		$sql->query("UPDATE tb_usuarios set login_user = :LOGIN, senha_user = :PASSWORD WHERE id_user = :ID", array(
			':LOGIN'=>$this->getLogin(),
			':PASSWORD'=>$this->getSenha(),
			':ID'=>$this->getIdusuario()

		));
	}

	public function delete(){
		$sql = new sql();
		$sql->query("DELETE FROM tb_usuarios WHERE id_user = :ID", array(
		':ID'=>$this->getIdusuario()
		));

		$this->setIdusuario(0);
		$this->setLogin("");
		$this->setSenha("");
		$this->setCadastro(new DateTime());

	}

	public function __construct($login="", $password=""){
		$this->setLogin($login);
		$this->setSenha($password);

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
