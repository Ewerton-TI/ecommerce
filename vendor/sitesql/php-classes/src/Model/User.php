<?php

namespace Site\Model;

use \Site\DB\Sql;
use Site\Model;
class User extends Model{

	const SESSION = "User";

	public static function login($login,$password){

		$sql = new sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			"LOGIN"=>$login
		));

		if(count($results) === 0){

			throw new \Exception("Usuário inexistente ou senha invalida.");
		}

		$data = $results[0];

		if (password_verify($password,$data["despassword"]) === true)
		{

			$user = new User();

			$user->setiData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;
		}else{
		throw new \Exception("Usuário inexistente ou senha");
		}
	}

	public static function verifyLogin($inadmin = true)
	{
		if(
			!isset($_SESSION[User::SESSION]) 
			|| 
			!$_SESSION[User::SESSION] 
			|| 
			!(int)$_SESSION[User::SESSION]["iduser"] > 0
			||
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
		) {
			header("Location: /admin/login");
			exit;
		}
	}

	public static function logout()
	{
		$_SESSION[User::SESSION] = NULL;
	}
}
?>