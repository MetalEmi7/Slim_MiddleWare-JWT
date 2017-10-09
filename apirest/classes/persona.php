<?php
class Persona
{
	public $id;
	public $nombre;
	public $mail;
	public $password;
	public $foto;
	public $sexo;

	public function deletePersona()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("
				delete 
				from personas 				
				WHERE id=:id");
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);

		$consulta->execute();
		
		return $consulta->rowCount();
	}

	public function updatePersona()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("
				update personas
				set nombre = :nombre,
				mail =:mail,
				password =:password,
				foto = :foto,
				sexo = :sexo
				WHERE id =:id");
		$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
		$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		$consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
		$consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
		$consulta->bindValue(':sexo', $this->sexo, PDO::PARAM_STR);

		return $consulta->execute();
	}

	public function insertPersona()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("
				insert into personas 
				(nombre,mail,password,foto,sexo)
				values (:nombre,:mail,:password,:foto,:sexo)");

		$consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		$consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
		$consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
		$consulta->bindValue(':sexo', $this->sexo, PDO::PARAM_STR);
		$consulta->execute();

		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}














	public static function getAllPersonas()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

		$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from personas");
		$consulta->execute();

		return	json_encode($consulta->fetchAll(PDO::FETCH_CLASS, "persona"));
		//return $consulta->fetchAll(PDO::FETCH_CLASS, "persona");
	}








	





	public static function getPersonaById($personaid)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select * from personas where id = :id");
		$consulta->bindValue(':id', $personaid, PDO::PARAM_INT);
		$consulta->execute();
		$persona = $consulta->fetchObject('Persona');
		return $persona;
	}

	public static function getPersonaDataByEmailAndPassword($mail, $password)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select mail,password from personas where mail = :mail and password = :password");
		$consulta->bindValue(':password', $password, PDO::PARAM_STR);
		$consulta->bindValue(':mail', $mail, PDO::PARAM_STR);
		$consulta->execute();
		return $consulta->fetchObject('Persona');
	}

	public static function personaAlreadyExist($email)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select email,password from personas where email = :email");
		$consulta->bindValue(':email', $email, PDO::PARAM_STR);
		$consulta->execute();
		return $consulta->rowCount() > 0;
	}
}