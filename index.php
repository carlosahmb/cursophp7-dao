<?php 

require_once("config.php");

//$sql = new sql();

//$usuarios =  $sql->select("SELECT * FROM tb_usuarios");

//echo json_encode($usuarios);

//carrega um usuario
//$root = new usuario();
//$root->loadbyId(1);
//echo $root;
 
//carrega todos os usuarios
//$lista = Usuario::getList();
//echo json_encode($lista);

//busca de usuarios com like
//$search = Usuario::search("car");
//echo json_encode($search);

//carrega usuario usando login e senha;

$usuario = new Usuario();
$usuario->login("user","123456");

echo $usuario;
 ?>